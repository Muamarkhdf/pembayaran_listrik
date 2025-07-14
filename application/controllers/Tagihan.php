<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

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
     * Shows list of bills
     */
    public function index()
    {
        // Get all bills with customer and tariff info
        $data['tagihan'] = $this->get_all_bills();
        $data['page_title'] = 'Data Tagihan';
        $data['active_page'] = 'tagihan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tagihan.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Add new bill form
     */
    public function add()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
            $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                $id_pelanggan = $this->input->post('id_pelanggan');
                $bulan = $this->input->post('bulan');
                $tahun = $this->input->post('tahun');
                $meter_awal = $this->input->post('meter_awal');
                $meter_akhir = $this->input->post('meter_akhir');
                $jumlah_meter = $meter_akhir - $meter_awal;
                
                // Check if usage already exists
                $existing_usage = $this->db->query(
                    "SELECT id_penggunaan FROM penggunaan WHERE id_pelanggan = ? AND bulan = ? AND tahun = ?",
                    array($id_pelanggan, $bulan, $tahun)
                )->row();
                
                if ($existing_usage) {
                    $this->session->set_flashdata('error', 'Data penggunaan untuk bulan dan tahun ini sudah ada!');
                } else {
                    // Insert usage data
                    $usage_data = array(
                        'id_pelanggan' => $id_pelanggan,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'meter_awal' => $meter_awal,
                        'meter_ahir' => $meter_akhir
                    );
                    
                    $this->db->insert('penggunaan', $usage_data);
                    $id_penggunaan = $this->db->insert_id();
                    
                    // Insert bill data
                    $bill_data = array(
                        'id_penggunaan' => $id_penggunaan,
                        'id_pelanggan' => $id_pelanggan,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'jumlah_meter' => $jumlah_meter,
                        'status' => 'belum_bayar'
                    );
                    
                    $this->db->insert('tagihan', $bill_data);
                    
                    $this->session->set_flashdata('success', 'Tagihan berhasil ditambahkan!');
                    
                    // Redirect to bill list
                    redirect('tagihan');
                }
            }
        }
        
        // Get customers for dropdown
        $data['pelanggan'] = $this->get_all_customers();
        $data['page_title'] = 'Tambah Tagihan';
        $data['active_page'] = 'tagihan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tagihan_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit bill
     */
    public function edit($id = NULL)
    {
        if ($id === NULL) {
            redirect('tagihan');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
            $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                $meter_awal = $this->input->post('meter_awal');
                $meter_akhir = $this->input->post('meter_akhir');
                $jumlah_meter = $meter_akhir - $meter_awal;
                
                // Get bill data
                $bill = $this->get_bill_by_id($id);
                
                if ($bill) {
                    // Update usage data
                    $usage_data = array(
                        'meter_awal' => $meter_awal,
                        'meter_ahir' => $meter_akhir
                    );
                    
                    $this->db->where('id_penggunaan', $bill['id_penggunaan']);
                    $this->db->update('penggunaan', $usage_data);
                    
                    // Update bill data
                    $bill_data = array(
                        'jumlah_meter' => $jumlah_meter
                    );
                    
                    $this->db->where('id_tagihan', $id);
                    $this->db->update('tagihan', $bill_data);
                    
                    $this->session->set_flashdata('success', 'Tagihan berhasil diupdate!');
                    
                    // Redirect to bill list
                    redirect('tagihan');
                }
            }
        }
        
        // Get bill data
        $data['tagihan'] = $this->get_bill_by_id($id);
        
        if (!$data['tagihan']) {
            redirect('tagihan');
        }
        
        $data['page_title'] = 'Edit Tagihan';
        $data['active_page'] = 'tagihan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tagihan_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete bill
     */
    public function delete($id = NULL)
    {
        if ($id === NULL) {
            redirect('tagihan');
        }
        
        // Get bill data
        $bill = $this->get_bill_by_id($id);
        
        if ($bill) {
            // Check if bill is already paid
            if ($bill['status'] == 'sudah_bayar') {
                $this->session->set_flashdata('error', 'Tagihan yang sudah dibayar tidak dapat dihapus!');
            } else {
                // Delete bill
                $this->db->where('id_tagihan', $id);
                $this->db->delete('tagihan');
                
                // Delete usage
                $this->db->where('id_penggunaan', $bill['id_penggunaan']);
                $this->db->delete('penggunaan');
                
                $this->session->set_flashdata('success', 'Tagihan berhasil dihapus.');
            }
        }
        
        redirect('tagihan');
    }

    /**
     * Process payment
     */
    public function bayar($id = NULL)
    {
        if ($id === NULL) {
            redirect('tagihan');
        }
        
        // Get bill data
        $bill = $this->get_bill_by_id($id);
        
        if (!$bill) {
            redirect('tagihan');
        }
        
        if ($bill['status'] == 'sudah_bayar') {
            $this->session->set_flashdata('error', 'Tagihan ini sudah dibayar!');
            redirect('tagihan');
        }
        
        if ($this->input->post()) {
            // Calculate total payment
            $tarif = $bill['tarifperkwh'];
            $jumlah_meter = $bill['jumlah_meter'];
            $biaya_admin = 10000; // Fixed admin fee
            $total_bayar = ($tarif * $jumlah_meter) + $biaya_admin;
            
            // Insert payment data
            $payment_data = array(
                'id_tagihan' => $id,
                'id_pelanggan' => $bill['id_pelanggan'],
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bulan_bayar' => $bill['bulan'],
                'biaya_admin' => $biaya_admin,
                'total_bayar' => $total_bayar,
                'id_user' => $this->session->userdata('user_id')
            );
            
            $this->db->insert('pembayaran', $payment_data);
            
            // Update bill status
            $this->db->where('id_tagihan', $id);
            $this->db->update('tagihan', array('status' => 'sudah_bayar'));
            
            $this->session->set_flashdata('success', 'Pembayaran berhasil diproses!');
            redirect('tagihan');
        }
        
        // Calculate payment details
        $data['tagihan'] = $bill;
        $data['tarif'] = $bill['tarifperkwh'];
        $data['jumlah_meter'] = $bill['jumlah_meter'];
        $data['biaya_admin'] = 10000;
        $data['total_bayar'] = ($bill['tarifperkwh'] * $bill['jumlah_meter']) + 10000;
        
        $data['page_title'] = 'Proses Pembayaran';
        $data['active_page'] = 'tagihan';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tagihan_bayar.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Get all bills with customer and tariff info
     */
    private function get_all_bills() {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, p.nomor_kwh, tr.daya, tr.tarifperkwh,
                   (tr.tarifperkwh * t.jumlah_meter) as total_tagihan,
                   CASE 
                       WHEN t.status = 'sudah_bayar' THEN 'Sudah Bayar'
                       ELSE 'Belum Bayar'
                   END as status_text
            FROM tagihan t
            LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            ORDER BY t.tahun DESC, t.bulan DESC
        ");
        
        return $query->result_array();
    }

    /**
     * Get bill by ID
     */
    private function get_bill_by_id($id) {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, p.nomor_kwh, tr.daya, tr.tarifperkwh,
                   pg.meter_awal, pg.meter_ahir
            FROM tagihan t
            LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            LEFT JOIN penggunaan pg ON t.id_penggunaan = pg.id_penggunaan
            WHERE t.id_tagihan = ?
        ", array($id));
        
        return $query->row_array();
    }

    /**
     * Get all customers
     */
    private function get_all_customers() {
        $query = $this->db->query("
            SELECT p.*, tr.daya, tr.tarifperkwh
            FROM pelanggan p
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            ORDER BY p.nama_pelanggan
        ");
        
        return $query->result_array();
    }
} 