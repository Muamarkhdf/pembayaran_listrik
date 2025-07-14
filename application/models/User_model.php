<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'user';

    public function get_all_users() {
        $this->db->select('user.*, level.nama_level');
        $this->db->from($this->table);
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        $this->db->order_by('user.nama_admin ASC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('user.*, level.nama_level');
        $this->db->from($this->table);
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        $this->db->where('user.id_user', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_username($username) {
        $this->db->select('user.*, level.nama_level');
        $this->db->from($this->table);
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        $this->db->where('user.username', $username);
        return $this->db->get()->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_user', $id);
        return $this->db->delete($this->table);
    }

    public function check_existing_username($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id_user !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function authenticate($username, $password) {
        $this->db->select('user.*, level.nama_level');
        $this->db->from($this->table);
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        $this->db->where('user.username', $username);
        $this->db->where('user.password', $password);
        return $this->db->get()->row_array();
    }

    public function get_user_statistics() {
        $stats = [];
        
        // Total users
        $stats['total_users'] = $this->db->count_all($this->table);
        
        // Users by level
        $this->db->select('level.nama_level, COUNT(user.id_user) as jumlah');
        $this->db->from($this->table);
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        $this->db->group_by('level.id_level');
        $stats['users_by_level'] = $this->db->get()->result_array();
        
        return $stats;
    }
} 