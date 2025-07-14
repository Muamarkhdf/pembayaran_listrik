<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_model extends CI_Model {
    protected $table = 'tarif';

    public function get_all_tarif() {
        $this->db->order_by('daya ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id) {
        $this->db->where('id_tarif', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_by_daya($daya) {
        $this->db->where('daya', $daya);
        return $this->db->get($this->table)->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_tarif', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        // Check if tarif is used by any customer
        $this->db->where('id_tarif', $id);
        $used = $this->db->get('pelanggan')->num_rows() > 0;
        
        if ($used) {
            return false; // Cannot delete if used by customers
        }
        
        $this->db->where('id_tarif', $id);
        return $this->db->delete($this->table);
    }

    public function check_existing_daya($daya, $exclude_id = null) {
        $this->db->where('daya', $daya);
        if ($exclude_id) {
            $this->db->where('id_tarif !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function get_tarif_statistics() {
        $stats = [];
        
        // Total tarif
        $stats['total_tarif'] = $this->db->count_all($this->table);
        
        // Average tarif per kWh
        $this->db->select('AVG(tarifperkwh) as rata_rata_tarif');
        $result = $this->db->get($this->table)->row();
        $stats['rata_rata_tarif'] = $result ? $result->rata_rata_tarif : 0;
        
        // Highest and lowest tarif
        $this->db->select('MAX(tarifperkwh) as tarif_tertinggi, MIN(tarifperkwh) as tarif_terendah');
        $result = $this->db->get($this->table)->row();
        $stats['tarif_tertinggi'] = $result ? $result->tarif_tertinggi : 0;
        $stats['tarif_terendah'] = $result ? $result->tarif_terendah : 0;
        
        return $stats;
    }

    public function get_usage_by_tarif() {
        $query = $this->db->query("
            SELECT 
                tarif.daya,
                tarif.tarifperkwh,
                COUNT(pelanggan.id_pelanggan) as jumlah_pelanggan,
                COUNT(tagihan.id_tagihan) as jumlah_tagihan,
                SUM(tagihan.jumlah_meter) as total_kwh
            FROM tarif
            LEFT JOIN pelanggan ON pelanggan.id_tarif = tarif.id_tarif
            LEFT JOIN tagihan ON tagihan.id_pelanggan = pelanggan.id_pelanggan
            GROUP BY tarif.id_tarif
            ORDER BY tarif.daya ASC
        ");
        return $query->result_array();
    }
} 