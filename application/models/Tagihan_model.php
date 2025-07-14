<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {
    protected $table = 'tagihan';

    public function get_all_tagihan() {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->order_by('tagihan.tahun DESC, tagihan.bulan DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('tagihan.id_tagihan', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_pelanggan($id_pelanggan) {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('tagihan.id_pelanggan', $id_pelanggan);
        $this->db->order_by('tagihan.tahun DESC, tagihan.bulan DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_period($bulan, $tahun) {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('tagihan.bulan', $bulan);
        $this->db->where('tagihan.tahun', $tahun);
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_tagihan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_tagihan', $id);
        return $this->db->delete($this->table);
    }

    public function get_unpaid_tagihan() {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('tagihan.status', 'belum_bayar');
        $this->db->order_by('tagihan.tahun DESC, tagihan.bulan DESC');
        return $this->db->get()->result_array();
    }

    public function get_paid_tagihan() {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, penggunaan.meter_awal, penggunaan.meter_ahir');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->where('tagihan.status', 'sudah_bayar');
        $this->db->order_by('tagihan.tahun DESC, tagihan.bulan DESC');
        return $this->db->get()->result_array();
    }

    public function set_paid($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update($this->table, ['status' => 'sudah_bayar']);
    }

    public function set_unpaid($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update($this->table, ['status' => 'belum_bayar']);
    }

    /**
     * Check if tagihan exists for a specific usage
     */
    public function check_by_penggunaan($id_penggunaan) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Get tagihan statistics
     */
    public function get_tagihan_statistics() {
        $query = $this->db->query("
            SELECT 
                COUNT(id_tagihan) as total_tagihan,
                SUM(CASE WHEN status = 'belum_bayar' THEN 1 ELSE 0 END) as belum_bayar,
                SUM(CASE WHEN status = 'sudah_bayar' THEN 1 ELSE 0 END) as sudah_bayar,
                SUM(jumlah_meter) as total_kwh
            FROM tagihan
        ");
        return $query->row_array();
    }

    /**
     * Get monthly tagihan statistics
     */
    public function get_monthly_tagihan($tahun) {
        $query = $this->db->query("
            SELECT 
                bulan,
                COUNT(id_tagihan) as jumlah_tagihan,
                SUM(CASE WHEN status = 'belum_bayar' THEN 1 ELSE 0 END) as belum_bayar,
                SUM(CASE WHEN status = 'sudah_bayar' THEN 1 ELSE 0 END) as sudah_bayar,
                SUM(jumlah_meter) as total_kwh
            FROM tagihan
            WHERE tahun = ?
            GROUP BY bulan
            ORDER BY FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')
        ", array($tahun));
        return $query->result_array();
    }
} 