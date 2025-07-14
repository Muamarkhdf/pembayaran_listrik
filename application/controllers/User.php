<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
        // Load helper
        $this->load->helper('url');
        // Load form validation library
        $this->load->library('form_validation');
        // Load session library
        $this->load->library('session');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    /**
     * Index Page for this controller.
     * Shows list of users
     */
    public function index()
    {
        // Get all users
        $data['users'] = $this->get_all_users();
        $data['page_title'] = 'Data User';
        $data['active_page'] = 'user';
        
        // Set the content view
        $data['content'] = 'application/views/pages/user.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Add new user form
     */
    public function add()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
            $this->form_validation->set_rules('id_level', 'Level', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // Insert user data
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'nama_admin' => $this->input->post('nama_admin'),
                    'id_level' => $this->input->post('id_level')
                );
                
                $this->db->insert('user', $data);
                
                $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
                
                // Redirect to user list
                redirect('user');
            }
        }
        
        // Get levels for dropdown
        $data['levels'] = $this->get_all_levels();
        $data['page_title'] = 'Tambah User';
        $data['active_page'] = 'user';
        
        // Set the content view
        $data['content'] = 'application/views/pages/user_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit user
     */
    public function edit($id = NULL)
    {
        if ($id === NULL) {
            redirect('user');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
            $this->form_validation->set_rules('id_level', 'Level', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // Update user data
                $data = array(
                    'username' => $this->input->post('username'),
                    'nama_admin' => $this->input->post('nama_admin'),
                    'id_level' => $this->input->post('id_level')
                );
                
                // Add password if provided
                if ($this->input->post('password')) {
                    $data['password'] = md5($this->input->post('password'));
                }
                
                $this->db->where('id_user', $id);
                $this->db->update('user', $data);
                
                $this->session->set_flashdata('success', 'User berhasil diupdate!');
                
                // Redirect to user list
                redirect('user');
            }
        }
        
        // Get user data
        $data['user'] = $this->get_user_by_id($id);
        
        if (!$data['user']) {
            redirect('user');
        }
        
        // Get levels for dropdown
        $data['levels'] = $this->get_all_levels();
        $data['page_title'] = 'Edit User';
        $data['active_page'] = 'user';
        
        // Set the content view
        $data['content'] = 'application/views/pages/user_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete user
     */
    public function delete($id = NULL)
    {
        if ($id === NULL) {
            redirect('user');
        }
        
        // Prevent deleting own account
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri!');
            redirect('user');
        }
        
        // Delete user
        $this->db->where('id_user', $id);
        $this->db->delete('user');
        
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        
        redirect('user');
    }

    /**
     * Get all users
     */
    private function get_all_users() {
        $query = $this->db->query("
            SELECT u.*, l.nama_level 
            FROM user u 
            LEFT JOIN level l ON u.id_level = l.id_level 
            ORDER BY u.nama_admin
        ");
        
        return $query->result_array();
    }

    /**
     * Get user by ID
     */
    private function get_user_by_id($id) {
        $query = $this->db->query("SELECT * FROM user WHERE id_user = ?", array($id));
        return $query->row_array();
    }

    /**
     * Get all levels
     */
    private function get_all_levels() {
        $query = $this->db->query("SELECT * FROM level ORDER BY nama_level");
        return $query->result_array();
    }
} 