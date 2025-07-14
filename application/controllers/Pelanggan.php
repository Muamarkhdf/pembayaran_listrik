<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pelanggan_model');
        $this->load->model('Tarif_model');
        
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
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['page_title'] = 'Data Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pelanggan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pelanggan' => $data['pelanggan']
        ]);
    }

    /**
     * Add new customer form
     */
    public function add()
    {
        $data['tarif'] = $this->Tarif_model->get_all_tarif();
        $data['page_title'] = 'Tambah Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('id_tarif', 'Daya/Tarif', 'required');
            
            if ($this->form_validation->run() === TRUE) {
                // Check if username already exists
                if ($this->Pelanggan_model->check_existing_username($this->input->post('username'))) {
                    $this->session->set_flashdata('error', 'Username sudah digunakan!');
                    redirect('pelanggan/add');
                }
                
                // Check if nomor_kwh already exists
                if ($this->Pelanggan_model->check_existing_nomor_kwh($this->input->post('nomor_kwh'))) {
                    $this->session->set_flashdata('error', 'Nomor KWH sudah terdaftar!');
                    redirect('pelanggan/add');
                }
                
                // Insert customer data
                $data_pelanggan = [
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'id_tarif' => $this->input->post('id_tarif')
                ];
                
                $result = $this->Pelanggan_model->insert($data_pelanggan);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Data pelanggan berhasil ditambahkan!');
                    redirect('pelanggan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data pelanggan!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pelanggan_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'tarif' => $data['tarif']
        ]);
    }

    /**
     * Edit customer
     */
    public function edit($id = null)
    {
        if (!$id) {
            redirect('pelanggan');
        }
        
        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($id);
        $data['tarif'] = $this->Tarif_model->get_all_tarif();
        $data['page_title'] = 'Edit Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('id_tarif', 'Daya/Tarif', 'required');
            
            if ($this->form_validation->run() === TRUE) {
                // Check if username already exists (excluding current record)
                if ($this->Pelanggan_model->check_existing_username($this->input->post('username'), $id)) {
                    $this->session->set_flashdata('error', 'Username sudah digunakan!');
                    redirect('pelanggan/edit/' . $id);
                }
                
                // Check if nomor_kwh already exists (excluding current record)
                if ($this->Pelanggan_model->check_existing_nomor_kwh($this->input->post('nomor_kwh'), $id)) {
                    $this->session->set_flashdata('error', 'Nomor KWH sudah terdaftar!');
                    redirect('pelanggan/edit/' . $id);
                }
                
                // Update customer data
                $data_pelanggan = [
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'username' => $this->input->post('username'),
                    'id_tarif' => $this->input->post('id_tarif')
                ];
                
                // Update password if provided
                if ($this->input->post('password')) {
                    $data_pelanggan['password'] = md5($this->input->post('password'));
                }
                
                $result = $this->Pelanggan_model->update($id, $data_pelanggan);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Data pelanggan berhasil diupdate!');
                    redirect('pelanggan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data pelanggan!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pelanggan_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pelanggan' => $data['pelanggan'],
            'tarif' => $data['tarif']
        ]);
    }

    /**
     * Delete customer
     */
    public function delete($id = null)
    {
        if (!$id) {
            redirect('pelanggan');
        }
        
        // Check if customer exists
        $pelanggan = $this->Pelanggan_model->get_by_id($id);
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan');
        }
        
        // Check if customer has usage records
        $this->load->model('Penggunaan_model');
        $penggunaan = $this->Penggunaan_model->get_by_pelanggan($id);
        if (!empty($penggunaan)) {
            $this->session->set_flashdata('error', 'Pelanggan tidak dapat dihapus karena memiliki data penggunaan!');
            redirect('pelanggan');
        }
        
        // Check if customer has bills
        $this->load->model('Tagihan_model');
        $tagihan = $this->Tagihan_model->get_by_pelanggan($id);
        if (!empty($tagihan)) {
            $this->session->set_flashdata('error', 'Pelanggan tidak dapat dihapus karena memiliki tagihan!');
            redirect('pelanggan');
        }
        
        // Check if customer has payments
        $this->load->model('Pembayaran_model');
        $pembayaran = $this->db->where('id_pelanggan', $id)->get('pembayaran')->result_array();
        if (!empty($pembayaran)) {
            $this->session->set_flashdata('error', 'Pelanggan tidak dapat dihapus karena memiliki data pembayaran!');
            redirect('pelanggan');
        }
        
        $result = $this->Pelanggan_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pelanggan!');
        }
        
        redirect('pelanggan');
    }

    /**
     * Detail customer
     */
    public function detail($id = null)
    {
        if (!$id) {
            redirect('pelanggan');
        }
        
        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($id);
        $data['page_title'] = 'Detail Pelanggan';
        $data['active_page'] = 'pelanggan';
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
            redirect('pelanggan');
        }
        
        // Get related data
        $this->load->model('Penggunaan_model');
        $this->load->model('Tagihan_model');
        $this->load->model('Pembayaran_model');
        
        $data['penggunaan'] = $this->Penggunaan_model->get_by_pelanggan($id);
        $data['tagihan'] = $this->Tagihan_model->get_by_pelanggan($id);
        $data['pembayaran'] = $this->db->where('id_pelanggan', $id)->get('pembayaran')->result_array();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pelanggan_detail.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pelanggan' => $data['pelanggan'],
            'penggunaan' => $data['penggunaan'],
            'tagihan' => $data['tagihan'],
            'pembayaran' => $data['pembayaran']
        ]);
    }
} 