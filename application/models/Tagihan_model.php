<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {
    protected $table = 'tagihan';

    public function get_by_id($id) {
        $this->db->where('id_tagihan', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_unpaid_tagihan() {
        $this->db->where('status', 'belum_bayar');
        return $this->db->get($this->table)->result_array();
    }

    public function set_paid($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update($this->table, ['status' => 'sudah_bayar']);
    }

    public function set_unpaid($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update($this->table, ['status' => 'belum_bayar']);
    }
} 