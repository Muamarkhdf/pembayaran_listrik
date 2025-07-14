<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelangganDashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
        // Load helper
        $this->load->helper('url');
        // Load session library
        $this->load->library('session');
        
        // Check if user is logged in and is customer
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'pelanggan') {
            redirect('auth');
        }
    }

    /**
     * Test method for debugging
     */
    public function test()
    {
        echo "PelangganDashboard controller is working!";
        echo "<br>Session data: ";
        print_r($this->session->userdata());
        echo "<br>User ID: " . $this->session->userdata('user_id');
        echo "<br>User Type: " . $this->session->userdata('user_type');
    }

    /**
     * Simple dashboard for testing
     */
    public function simple_dashboard()
    {
        $customer_id = $this->session->userdata('user_id');
        
        // Get customer data
        $data = $this->get_customer_dashboard_data($customer_id);
        
        // Simple view without complex template
        echo "<h1>Dashboard Pelanggan</h1>";
        echo "<p>Selamat datang, " . ($data['customer_info']['nama_pelanggan'] ?? 'Pelanggan') . "</p>";
        echo "<p>Total Tagihan: " . $data['total_tagihan'] . "</p>";
        echo "<p>Belum Bayar: " . $data['tagihan_belum_bayar'] . "</p>";
        echo "<p>Sudah Bayar: " . $data['tagihan_sudah_bayar'] . "</p>";
        
        echo "<h2>Tagihan Terbaru</h2>";
        if (!empty($data['tagihan_terbaru'])) {
            foreach ($data['tagihan_terbaru'] as $tagihan) {
                echo "<p>" . $tagihan['bulan'] . " " . $tagihan['tahun'] . " - Rp " . number_format($tagihan['total_tagihan']) . "</p>";
            }
        } else {
            echo "<p>Tidak ada tagihan</p>";
        }
    }

    /**
     * Simple index with basic template
     */
    public function simple_index()
    {
        // Get customer data
        $customer_id = $this->session->userdata('user_id');
        
        // Get dashboard data
        $data = $this->get_customer_dashboard_data($customer_id);
        
        // Set the content view
        $data['content'] = 'pages/pelanggan_dashboard_simple.php';
        
        // Debug: Check if data is loaded
        if (empty($data['customer_info'])) {
            echo "Error: Customer info not found for ID: " . $customer_id;
            return;
        }
        
        // Load the customer dashboard view
        $this->load->view('layouts/pelanggan_main', $data);
    }

    /**
     * Simple index with simple template
     */
    public function simple_index_with_template()
    {
        // Get customer data
        $customer_id = $this->session->userdata('user_id');
        
        // Get dashboard data
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
     * Index Page for customer dashboard
     */
    public function index()
    {
        // Get customer data
        $customer_id = $this->session->userdata('user_id');
        
        // Get dashboard data
        $data = $this->get_customer_dashboard_data($customer_id);
        
        // Set the content view
        $data['content'] = 'pages/pelanggan_dashboard.php';
        
        // Debug: Check if data is loaded
        if (empty($data['customer_info'])) {
            echo "Error: Customer info not found for ID: " . $customer_id;
            return;
        }
        
        // Load the customer dashboard view
        $this->load->view('layouts/pelanggan_main', $data);
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

    /**
     * Customer profile page
     */
    public function profile()
    {
        $customer_id = $this->session->userdata('user_id');
        
        $data['customer_info'] = $this->get_customer_info($customer_id);
        $data['page_title'] = 'Profil Saya';
        $data['active_page'] = 'profile';
        $data['content'] = 'pages/pelanggan_profile.php';
        
        $this->load->view('layouts/pelanggan_main', $data);
    }

    /**
     * Customer bills page
     */
    public function bills()
    {
        $customer_id = $this->session->userdata('user_id');
        
        $data['tagihan'] = $this->get_all_bills($customer_id);
        $data['page_title'] = 'Tagihan Saya';
        $data['active_page'] = 'bills';
        $data['content'] = 'pages/pelanggan_bills.php';
        
        $this->load->view('layouts/pelanggan_main', $data);
    }

    /**
     * Get all bills for customer
     */
    private function get_all_bills($customer_id) {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, tr.tarifperkwh,
                   (t.jumlah_meter * tr.tarifperkwh) as total_tagihan
            FROM tagihan t
            JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            WHERE t.id_pelanggan = ?
            ORDER BY t.tahun DESC, t.bulan DESC
        ", array($customer_id));
        
        return $query->result_array();
    }

    /**
     * Customer usage page
     */
    public function usage()
    {
        $customer_id = $this->session->userdata('user_id');
        
        $data['penggunaan'] = $this->get_all_usage($customer_id);
        $data['page_title'] = 'Penggunaan Listrik';
        $data['active_page'] = 'usage';
        $data['content'] = 'pages/pelanggan_usage.php';
        
        $this->load->view('layouts/pelanggan_main', $data);
    }

    /**
     * Get all usage for customer
     */
    private function get_all_usage($customer_id) {
        $query = $this->db->query("
            SELECT png.*, (png.meter_ahir - png.meter_awal) as total_kwh
            FROM penggunaan png
            WHERE png.id_pelanggan = ?
            ORDER BY png.tahun DESC, png.bulan DESC
        ", array($customer_id));
        
        return $query->result_array();
    }

    /**
     * Customer payment history page
     */
    public function payment_history()
    {
        $customer_id = $this->session->userdata('user_id');
        
        $data['pembayaran'] = $this->get_all_payments($customer_id);
        $data['page_title'] = 'Riwayat Pembayaran';
        $data['active_page'] = 'payment_history';
        $data['content'] = 'pages/pelanggan_payment_history.php';
        
        $this->load->view('layouts/pelanggan_main', $data);
    }

    /**
     * Get all payments for customer
     */
    private function get_all_payments($customer_id) {
        $query = $this->db->query("
            SELECT pmb.*, t.bulan, t.tahun, t.jumlah_meter, p.nama_pelanggan
            FROM pembayaran pmb
            JOIN tagihan t ON pmb.id_tagihan = t.id_tagihan
            JOIN pelanggan p ON pmb.id_pelanggan = p.id_pelanggan
            WHERE pmb.id_pelanggan = ?
            ORDER BY pmb.tanggal_pembayaran DESC
        ", array($customer_id));
        
        return $query->result_array();
    }

    /**
     * Customer usage charts page
     */
    public function usage_charts()
    {
        $customer_id = $this->session->userdata('user_id');
        
        $data['statistik_penggunaan'] = $this->get_usage_statistics($customer_id);
        $data['page_title'] = 'Grafik Penggunaan';
        $data['active_page'] = 'usage_charts';
        $data['content'] = 'pages/pelanggan_usage_chart.php';
        
        $this->load->view('layouts/pelanggan_main', $data);
    }
} 