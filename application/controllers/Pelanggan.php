<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

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
     * Shows list of customers
     */
    public function index()
    {
        // Get all customers
        $data['pelanggan'] = $this->get_all_customers();
        $data['page_title'] = 'Data Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/pelanggan.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Add new customer form
     */
    public function add()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|is_unique[pelanggan.nomor_kwh]');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[pelanggan.username]');
            
            if ($this->form_validation->run() == TRUE) {
                // Insert customer data
                $data = array(
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'id_tarif' => $this->input->post('id_tarif')
                );
                
                $this->db->insert('pelanggan', $data);
                
                // Redirect to customer list
                redirect('pelanggan');
            }
        }
        
        $data['page_title'] = 'Tambah Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/pelanggan_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit customer
     */
    public function edit($id = NULL)
    {
        if ($id === NULL) {
            redirect('pelanggan');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // Update customer data
                $data = array(
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'username' => $this->input->post('username'),
                    'id_tarif' => $this->input->post('id_tarif')
                );
                
                $this->db->where('id', $id);
                $this->db->update('pelanggan', $data);
                
                // Redirect to customer list
                redirect('pelanggan');
            }
        }
        
        // Get customer data
        $data['pelanggan'] = $this->get_customer_by_id($id);
        
        if (!$data['pelanggan']) {
            redirect('pelanggan');
        }
        
        $data['page_title'] = 'Edit Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/pelanggan_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete customer
     */
    public function delete($id = NULL)
    {
        if ($id === NULL) {
            redirect('pelanggan');
        }
        
        // Check if customer has bills
        $query = $this->db->query("SELECT COUNT(*) as total FROM tagihan WHERE id_pelanggan = ?", array($id));
        $result = $query->row();
        
        if ($result->total > 0) {
            // Customer has bills, cannot delete
            $this->session->set_flashdata('error', 'Pelanggan tidak dapat dihapus karena memiliki tagihan.');
        } else {
            // Delete customer
            $this->db->where('id_pelanggan', $id);
            $this->db->delete('pelanggan');
            
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus.');
        }
        
        redirect('pelanggan');
    }

    /**
     * Get all customers
     */
    private function get_all_customers() {
        $query = $this->db->query("
            SELECT p.*, 
                   COUNT(t.id_tagihan) as total_tagihan,
                   SUM(CASE WHEN t.status = 'belum_bayar' THEN 1 ELSE 0 END) as tagihan_belum_bayar
            FROM pelanggan p
            LEFT JOIN tagihan t ON p.id_pelanggan = t.id_pelanggan
            GROUP BY p.id_pelanggan
            ORDER BY p.nama_pelanggan
        ");
        
        return $query->result_array();
    }

    /**
     * Get customer by ID
     */
    private function get_customer_by_id($id) {
        $query = $this->db->query("SELECT * FROM pelanggan WHERE id_pelanggan = ?", array($id));
        return $query->row_array();
    }
} 