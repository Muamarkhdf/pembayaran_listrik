<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'user';

    public function get_by_id($id) {
        $this->db->where('id_user', $id);
        return $this->db->get($this->table)->row_array();
    }
} 