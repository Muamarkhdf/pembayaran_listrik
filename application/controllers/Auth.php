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
            // Redirect based on user type
            if ($this->session->userdata('user_type') == 'pelanggan') {
                redirect('pelanggan_dashboard');
            } else {
                redirect('dashboard');
            }
        }

        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));
                
                // First, check admin credentials
                $admin = $this->check_admin_credentials($username, $password);
                
                if ($admin) {
                    // Set session data for admin
                    $session_data = array(
                        'user_id' => $admin['id_user'],
                        'username' => $admin['username'],
                        'nama_admin' => $admin['nama_admin'],
                        'id_level' => $admin['id_level'],
                        'user_type' => 'admin',
                        'logged_in' => TRUE
                    );
                    
                    $this->session->set_userdata($session_data);
                    
                    // Redirect to admin dashboard
                    redirect('dashboard');
                } else {
                    // Check customer credentials
                    $pelanggan = $this->check_pelanggan_credentials($username, $password);
                    
                    if ($pelanggan) {
                        // Set session data for customer
                        $session_data = array(
                            'user_id' => $pelanggan['id_pelanggan'],
                            'username' => $pelanggan['username'],
                            'nama_pelanggan' => $pelanggan['nama_pelanggan'],
                            'nomor_kwh' => $pelanggan['nomor_kwh'],
                            'user_type' => 'pelanggan',
                            'logged_in' => TRUE
                        );
                        
                        $this->session->set_userdata($session_data);
                        
                        // Redirect to customer dashboard
                        redirect('customer');
                    } else {
                        $this->session->set_flashdata('error', 'Username atau password salah!');
                        redirect('auth');
                    }
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
     * Check admin credentials
     */
    private function check_admin_credentials($username, $password) {
        $query = $this->db->query("
            SELECT u.*, l.nama_level 
            FROM user u 
            LEFT JOIN level l ON u.id_level = l.id_level 
            WHERE u.username = ? AND u.password = ?
        ", array($username, $password));
        
        return $query->row_array();
    }

    /**
     * Check customer credentials
     */
    private function check_pelanggan_credentials($username, $password) {
        $query = $this->db->query("
            SELECT p.*, t.daya, t.tarifperkwh
            FROM pelanggan p 
            LEFT JOIN tarif t ON p.id_tarif = t.id_tarif 
            WHERE p.username = ? AND p.password = ?
        ", array($username, $password));
        
        return $query->row_array();
    }
} 