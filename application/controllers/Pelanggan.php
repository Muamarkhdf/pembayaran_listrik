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

    /**
     * Customer Dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in and is customer
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'pelanggan') {
            redirect('auth');
        }

        $customer_id = $this->session->userdata('user_id');
        
        // Get customer data
        $data = $this->get_customer_dashboard_data($customer_id);
        
        // Set the content view
        $data['content'] = 'pages/pelanggan_dashboard_simple.php';
        
        // Debug: Check if data is loaded
        if (empty($data['customer_info'])) {
            echo "Error: Customer info not found for ID: " . $customer_id;
            return;
        }
        
        // Load the simple template
        $this->load->view('layouts/pelanggan_main_simple', $data);
    }

    /**
     * Get customer dashboard statistics
     */
    private function get_customer_dashboard_data($customer_id) {
        $data = array();
        
        // Get customer information
        $data['customer_info'] = $this->get_customer_info($customer_id);
        
        // Get total bills
        $data['total_tagihan'] = $this->get_total_bills($customer_id);
        
        // Get unpaid bills
        $data['tagihan_belum_bayar'] = $this->get_unpaid_bills($customer_id);
        
        // Get paid bills
        $data['tagihan_sudah_bayar'] = $this->get_paid_bills($customer_id);
        
        // Get recent bills
        $data['tagihan_terbaru'] = $this->get_recent_bills($customer_id);
        
        // Get recent payments
        $data['pembayaran_terbaru'] = $this->get_recent_payments($customer_id);
        
        // Get usage statistics
        $data['statistik_penggunaan'] = $this->get_usage_statistics($customer_id);
        
        // Set page title and active page
        $data['page_title'] = 'Dashboard Pelanggan';
        $data['active_page'] = 'dashboard';
        
        return $data;
    }

    /**
     * Get customer information
     */
    private function get_customer_info($customer_id) {
        $query = $this->db->query("
            SELECT p.*, t.daya, t.tarifperkwh
            FROM pelanggan p
            LEFT JOIN tarif t ON p.id_tarif = t.id_tarif
            WHERE p.id_pelanggan = ?
        ", array($customer_id));
        
        return $query->row_array();
    }

    /**
     * Get total bills for customer
     */
    private function get_total_bills($customer_id) {
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE id_pelanggan = ?
        ", array($customer_id));
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get unpaid bills for customer
     */
    private function get_unpaid_bills($customer_id) {
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE id_pelanggan = ? AND status = 'belum_bayar'
        ", array($customer_id));
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get paid bills for customer
     */
    private function get_paid_bills($customer_id) {
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE id_pelanggan = ? AND status = 'sudah_bayar'
        ", array($customer_id));
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get recent bills for customer
     */
    private function get_recent_bills($customer_id) {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, tr.tarifperkwh,
                   (t.jumlah_meter * tr.tarifperkwh) as total_tagihan
            FROM tagihan t
            JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            WHERE t.id_pelanggan = ?
            ORDER BY t.bulan DESC, t.tahun DESC
            LIMIT 5
        ", array($customer_id));
        
        return $query->result_array();
    }

    /**
     * Get recent payments for customer
     */
    private function get_recent_payments($customer_id) {
        $query = $this->db->query("
            SELECT pmb.*, t.bulan, t.tahun, t.jumlah_meter
            FROM pembayaran pmb
            JOIN tagihan t ON pmb.id_tagihan = t.id_tagihan
            WHERE pmb.id_pelanggan = ?
            ORDER BY pmb.tanggal_pembayaran DESC
            LIMIT 5
        ", array($customer_id));
        
        return $query->result_array();
    }

    /**
     * Get usage statistics for customer
     */
    private function get_usage_statistics($customer_id) {
        $query = $this->db->query("
            SELECT 
                png.bulan,
                png.tahun,
                png.meter_awal,
                png.meter_ahir,
                (png.meter_ahir - png.meter_awal) as total_kwh
            FROM penggunaan png
            WHERE png.id_pelanggan = ?
            ORDER BY png.tahun DESC, png.bulan DESC
            LIMIT 6
        ", array($customer_id));
        
        return $query->result_array();
    }
} 