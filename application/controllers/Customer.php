<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
        // Load helper
        $this->load->helper('url');
        // Load session library
        $this->load->library('session');
    }

    /**
     * Customer Dashboard
     */
    public function index()
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