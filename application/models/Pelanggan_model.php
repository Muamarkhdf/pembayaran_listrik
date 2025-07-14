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

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_pelanggan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
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

    public function get_statistics() {
        $stats = [];
        
        // Total pelanggan
        $stats['total_pelanggan'] = $this->db->count_all($this->table);
        
        // Pelanggan aktif (dengan tagihan)
        $this->db->select('COUNT(DISTINCT pelanggan.id_pelanggan) as aktif');
        $this->db->from($this->table);
        $this->db->join('tagihan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $result = $this->db->get()->row();
        $stats['pelanggan_aktif'] = $result ? $result->aktif : 0;
        
        // Pelanggan baru bulan ini
        $current_month = date('Y-m');
        $this->db->where('DATE_FORMAT(created_at, "%Y-%m")', $current_month);
        $stats['pelanggan_baru'] = $this->db->count_all_results($this->table);
        
        return $stats;
    }
} 