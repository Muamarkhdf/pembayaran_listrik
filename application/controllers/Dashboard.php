<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
        // Load helper
        $this->load->helper('url');
        // Load session library
        $this->load->library('session');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/dashboard
     *	- or -
     * 		http://example.com/index.php/dashboard/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     */
    public function index()
    {
        // Get dashboard data
        $data = $this->get_dashboard_data();
        
        // Set the content view
        $data['content'] = 'application/views/pages/dashboard.php';
        
        // Load the dashboard view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Get dashboard statistics
     */
    private function get_dashboard_data() {
        $data = array();
        
        // Get total customers
        $data['total_pelanggan'] = $this->get_total_customers();
        
        // Get total bills this month
        $data['total_tagihan'] = $this->get_total_bills_this_month();
        
        // Get today's payments
        $data['pembayaran_hari_ini'] = $this->get_today_payments();
        
        // Get unpaid bills (hanya sekali, gunakan ulang)
        $unpaid_bills = $this->get_unpaid_bills();
        $data['tagihan_belum_bayar'] = $unpaid_bills;
        $data['belum_bayar'] = $unpaid_bills;
        
        // Get paid bills count
        $data['sudah_bayar'] = $this->get_paid_bills_count();
        
        // Get recent bills
        $data['tagihan_terbaru'] = $this->get_recent_bills();
        
        // Get recent activities (pastikan tidak double waktu)
        $data['aktivitas_terbaru'] = $this->get_recent_activities_unique();
        
        // Set page title and active page
        $data['page_title'] = 'Dashboard';
        $data['active_page'] = 'dashboard';
        
        return $data;
    }

    /**
     * Get total number of customers
     */
    private function get_total_customers() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM pelanggan");
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get total bills for current month
     */
    private function get_total_bills_this_month() {
        $current_month = date('F'); // Get current month name
        $current_year = date('Y');
        
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE bulan = ? AND tahun = ?
        ", array($current_month, $current_year));
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get today's payments
     */
    private function get_today_payments() {
        $today = date('Y-m-d');
        
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM pembayaran 
            WHERE DATE(tanggal_pembayaran) = ?
        ", array($today));
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get unpaid bills count
     */
    private function get_unpaid_bills() {
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE status = 'belum_bayar'
        ");
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get recent bills
     */
    private function get_recent_bills() {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, 
                   (t.jumlah_meter * tr.tarifperkwh) as total_tagihan
            FROM tagihan t
            JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            ORDER BY t.bulan DESC, t.tahun DESC
            LIMIT 5
        ");
        
        return $query->result_array();
    }

    /**
     * Get paid bills count
     */
    private function get_paid_bills_count() {
        $query = $this->db->query("
            SELECT COUNT(*) as total 
            FROM tagihan 
            WHERE status = 'sudah_bayar'
        ");
        
        $result = $query->row();
        return $result ? $result->total : 0;
    }

    /**
     * Get recent activities (unique by time+desc)
     */
    private function get_recent_activities_unique() {
        $activities = array();
        $unique = array();
        // Get recent payments
        $query = $this->db->query("
            SELECT p.*, t.bulan, t.tahun, pl.nama_pelanggan
            FROM pembayaran p
            JOIN tagihan t ON p.id_tagihan = t.id_tagihan
            JOIN pelanggan pl ON t.id_pelanggan = pl.id_pelanggan
            ORDER BY p.tanggal_pembayaran DESC
            LIMIT 5
        ");
        $payments = $query->result_array();
        foreach ($payments as $payment) {
            $key = md5('pay'.$payment['nama_pelanggan'].$payment['bulan'].$payment['tahun'].$payment['tanggal_pembayaran']);
            if (!isset($unique[$key])) {
                $activities[] = array(
                    'icon' => 'credit-card',
                    'title' => 'Pembayaran Tagihan',
                    'description' => 'Pembayaran tagihan ' . $payment['nama_pelanggan'] . ' - ' . $payment['bulan'] . ' ' . $payment['tahun'],
                    'time' => date('d M Y H:i', strtotime($payment['tanggal_pembayaran']))
                );
                $unique[$key] = true;
            }
        }
        // Get recent bill generation
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan
            FROM tagihan t
            JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            ORDER BY t.bulan DESC, t.tahun DESC
            LIMIT 3
        ");
        $bills = $query->result_array();
        foreach ($bills as $bill) {
            $key = md5('bill'.$bill['nama_pelanggan'].$bill['bulan'].$bill['tahun']);
            if (!isset($unique[$key])) {
                $activities[] = array(
                    'icon' => 'file-invoice',
                    'title' => 'Tagihan Baru',
                    'description' => 'Tagihan baru untuk ' . $bill['nama_pelanggan'] . ' - ' . $bill['bulan'] . ' ' . $bill['tahun'],
                    'time' => date('d M Y')
                );
                $unique[$key] = true;
            }
        }
        // Sort activities by time (most recent first)
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        return array_slice($activities, 0, 5);
    }
} 