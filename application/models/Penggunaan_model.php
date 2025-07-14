<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_model extends CI_Model {
    protected $table = 'penggunaan';

    public function get_all_penggunaan() {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tarif.daya, tarif.tarifperkwh');
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->where('penggunaan.id_penggunaan', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_pelanggan($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_period($bulan, $tahun) {
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_penggunaan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_penggunaan', $id);
        return $this->db->delete($this->table);
    }

    public function check_existing($id_pelanggan, $bulan, $tahun) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Check if usage already exists for a customer and period
     */
    public function check_existing_usage($id_pelanggan, $bulan, $tahun) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $result = $this->db->get($this->table)->row_array();
        return !empty($result);
    }

    /**
     * Check if usage already exists for a customer and period (excluding current record)
     */
    public function check_existing_usage_exclude($id_pelanggan, $bulan, $tahun, $exclude_id) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $this->db->where('id_penggunaan !=', $exclude_id);
        $result = $this->db->get($this->table)->row_array();
        return !empty($result);
    }

    /**
     * Check if usage is referenced in tagihan table
     */
    public function check_used_in_tagihan($id_penggunaan) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        $result = $this->db->get('tagihan')->row_array();
        return !empty($result);
    }

    public function get_usage_statistics() {
        $query = $this->db->query("
            SELECT 
                COUNT(id_penggunaan) as total_penggunaan,
                SUM(meter_ahir - meter_awal) as total_kwh,
                AVG(meter_ahir - meter_awal) as rata_rata_kwh,
                MAX(meter_ahir - meter_awal) as penggunaan_tertinggi,
                MIN(meter_ahir - meter_awal) as penggunaan_terendah
            FROM penggunaan
        ");
        return $query->row_array();
    }

    public function get_monthly_usage($tahun) {
        $query = $this->db->query("
            SELECT 
                bulan,
                COUNT(id_penggunaan) as jumlah_pelanggan,
                SUM(meter_ahir - meter_awal) as total_kwh,
                AVG(meter_ahir - meter_awal) as rata_rata_kwh
            FROM penggunaan
            WHERE tahun = ?
            GROUP BY bulan
            ORDER BY FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')
        ", array($tahun));
        return $query->result_array();
    }

    public function get_top_usage_customers($limit = 10) {
        $query = $this->db->query("
            SELECT 
                penggunaan.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                (penggunaan.meter_ahir - penggunaan.meter_awal) as penggunaan_kwh
            FROM penggunaan
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penggunaan.id_pelanggan
            ORDER BY (penggunaan.meter_ahir - penggunaan.meter_awal) DESC
            LIMIT ?
        ", array($limit));
        return $query->result_array();
    }
} 