<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
    }

    /**
     * Login page
     */
    public function index()
    {
        // Check if user is already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));
                
                // Check user credentials
                $user = $this->check_user_credentials($username, $password);
                
                if ($user) {
                    // Set session data
                    $session_data = array(
                        'user_id' => $user['id_user'],
                        'username' => $user['username'],
                        'nama_admin' => $user['nama_admin'],
                        'id_level' => $user['id_level'],
                        'logged_in' => TRUE
                    );
                    
                    $this->session->set_userdata($session_data);
                    
                    // Redirect to dashboard
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah!');
                    redirect('auth');
                }
            }
        }
        
        // Load login view
        $this->load->view('auth/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Destroy session
        $this->session->sess_destroy();
        
        // Redirect to login
        redirect('auth');
    }

    /**
     * Check user credentials
     */
    private function check_user_credentials($username, $password) {
        $query = $this->db->query("
            SELECT u.*, l.nama_level 
            FROM user u 
            LEFT JOIN level l ON u.id_level = l.id_level 
            WHERE u.username = ? AND u.password = ?
        ", array($username, $password));
        
        return $query->row_array();
    }
} 