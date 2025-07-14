<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

    protected $table = 'pelanggan';

    public function get_all_pelanggan() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->order_by('pelanggan.nama_pelanggan ASC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.id_pelanggan', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_username($username) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.username', $username);
        return $this->db->get()->row_array();
    }

    public function get_by_nomor_kwh($nomor_kwh) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.nomor_kwh', $nomor_kwh);
        return $this->db->get()->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_pelanggan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        // Check if customer has related data
        $this->db->where('id_pelanggan', $id);
        $has_usage = $this->db->get('penggunaan')->num_rows() > 0;
        
        $this->db->where('id_pelanggan', $id);
        $has_bills = $this->db->get('tagihan')->num_rows() > 0;
        
        $this->db->where('id_pelanggan', $id);
        $has_payments = $this->db->get('pembayaran')->num_rows() > 0;
        
        if ($has_usage || $has_bills || $has_payments) {
            return false; // Cannot delete if has related data
        }
        
        $this->db->where('id_pelanggan', $id);
        return $this->db->delete($this->table);
    }

    public function check_existing_username($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function check_existing_nomor_kwh($nomor_kwh, $exclude_id = null) {
        $this->db->where('nomor_kwh', $nomor_kwh);
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function authenticate($username, $password) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.username', $username);
        $this->db->where('pelanggan.password', $password);
        return $this->db->get()->row_array();
    }

    public function get_customer_statistics() {
        $stats = [];
        
        // Total customers
        $stats['total_pelanggan'] = $this->db->count_all($this->table);
        
        // Customers with bills
        $this->db->select('COUNT(DISTINCT pelanggan.id_pelanggan) as dengan_tagihan');
        $this->db->from($this->table);
        $this->db->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $result = $this->db->get()->row();
        $stats['pelanggan_dengan_tagihan'] = $result ? $result->dengan_tagihan : 0;
        
        // Customers with unpaid bills
        $this->db->select('COUNT(DISTINCT pelanggan.id_pelanggan) as belum_bayar');
        $this->db->from($this->table);
        $this->db->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->where('tagihan.status', 'belum_bayar');
        $result = $this->db->get()->row();
        $stats['pelanggan_belum_bayar'] = $result ? $result->belum_bayar : 0;
        
        // Customers by tariff
        $this->db->select('tarif.daya, COUNT(pelanggan.id_pelanggan) as jumlah');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->group_by('tarif.id_tarif');
        $stats['pelanggan_by_tarif'] = $this->db->get()->result_array();
        
        return $stats;
    }

    public function get_customers_with_bills() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh, COUNT(tagihan.id_tagihan) as total_tagihan, SUM(CASE WHEN tagihan.status = "belum_bayar" THEN 1 ELSE 0 END) as tagihan_belum_bayar');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->group_by('pelanggan.id_pelanggan');
        $this->db->order_by('pelanggan.nama_pelanggan ASC');
        return $this->db->get()->result_array();
    }

    public function get_customers_with_unpaid_bills() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh, COUNT(tagihan.id_tagihan) as total_tagihan_belum_bayar');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->where('tagihan.status', 'belum_bayar');
        $this->db->group_by('pelanggan.id_pelanggan');
        $this->db->order_by('pelanggan.nama_pelanggan ASC');
        return $this->db->get()->result_array();
    }

        public function search_customers($keyword) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->group_start();
        $this->db->like('pelanggan.nama_pelanggan', $keyword);
        $this->db->or_like('pelanggan.username', $keyword);
        $this->db->or_like('pelanggan.nomor_kwh', $keyword);
        $this->db->or_like('pelanggan.alamat', $keyword);
        $this->db->group_end();
        $this->db->order_by('pelanggan.nama_pelanggan ASC');
        return $this->db->get()->result_array();
    }
} 