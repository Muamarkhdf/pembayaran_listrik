<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pembayaran_model');
        $this->load->model('Tagihan_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Penggunaan_model');
        $this->load->model('User_model');
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['page_title'] = 'Laporan';
        $data['active_page'] = 'laporan';
        
        // Get summary statistics
        $data['summary'] = $this->get_summary_statistics();
        
        // Get recent payments
        $data['recent_payments'] = $this->get_recent_payments();
        
        // Get monthly statistics
        $data['monthly_stats'] = $this->get_monthly_statistics();
        
        // Get top customers
        $data['top_customers'] = $this->get_top_customers();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/laporan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'summary' => $data['summary'],
            'recent_payments' => $data['recent_payments'],
            'monthly_stats' => $data['monthly_stats'],
            'top_customers' => $data['top_customers']
        ]);
    }

    public function pembayaran() {
        $data['page_title'] = 'Laporan Pembayaran';
        $data['active_page'] = 'laporan';
        
        // Get filter parameters
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $pelanggan = $this->input->get('pelanggan');
        
        // Get payment data with filters
        $data['pembayaran'] = $this->get_payment_report($bulan, $tahun, $pelanggan);
        $data['total_pembayaran'] = $this->calculate_total_payment($data['pembayaran']);
        $data['total_admin'] = $this->calculate_total_admin($data['pembayaran']);
        
        // Get filter options
        $data['bulan_list'] = $this->get_bulan_list();
        $data['tahun_list'] = $this->get_tahun_list();
        $data['pelanggan_list'] = $this->get_pelanggan_list();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/laporan_pembayaran.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pembayaran' => $data['pembayaran'],
            'total_pembayaran' => $data['total_pembayaran'],
            'total_admin' => $data['total_admin'],
            'bulan_list' => $data['bulan_list'],
            'tahun_list' => $data['tahun_list'],
            'pelanggan_list' => $data['pelanggan_list'],
            'filter_bulan' => $bulan,
            'filter_tahun' => $tahun,
            'filter_pelanggan' => $pelanggan
        ]);
    }

    public function tagihan() {
        $data['page_title'] = 'Laporan Tagihan';
        $data['active_page'] = 'laporan';
        
        // Get filter parameters
        $status = $this->input->get('status');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        // Get bill data with filters
        $data['tagihan'] = $this->get_bill_report($status, $bulan, $tahun);
        $data['total_tagihan'] = $this->calculate_total_bill($data['tagihan']);
        $data['total_paid'] = $this->calculate_total_paid($data['tagihan']);
        $data['total_unpaid'] = $this->calculate_total_unpaid($data['tagihan']);
        
        // Get filter options
        $data['bulan_list'] = $this->get_bulan_list();
        $data['tahun_list'] = $this->get_tahun_list();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/laporan_tagihan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'tagihan' => $data['tagihan'],
            'total_tagihan' => $data['total_tagihan'],
            'total_paid' => $data['total_paid'],
            'total_unpaid' => $data['total_unpaid'],
            'bulan_list' => $data['bulan_list'],
            'tahun_list' => $data['tahun_list'],
            'filter_status' => $status,
            'filter_bulan' => $bulan,
            'filter_tahun' => $tahun
        ]);
    }

    public function pelanggan() {
        $data['page_title'] = 'Laporan Pelanggan';
        $data['active_page'] = 'laporan';
        
        // Get filter parameters
        $tarif = $this->input->get('tarif');
        $status = $this->input->get('status');
        
        // Get customer data with filters
        $data['pelanggan'] = $this->get_customer_report($tarif, $status);
        $data['total_customers'] = count($data['pelanggan']);
        $data['active_customers'] = $this->count_active_customers($data['pelanggan']);
        $data['inactive_customers'] = $this->count_inactive_customers($data['pelanggan']);
        
        // Get filter options
        $data['tarif_list'] = $this->get_tarif_list();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/laporan_pelanggan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pelanggan' => $data['pelanggan'],
            'total_customers' => $data['total_customers'],
            'active_customers' => $data['active_customers'],
            'inactive_customers' => $data['inactive_customers'],
            'tarif_list' => $data['tarif_list'],
            'filter_tarif' => $tarif,
            'filter_status' => $status
        ]);
    }

    public function penggunaan() {
        $data['page_title'] = 'Laporan Penggunaan';
        $data['active_page'] = 'laporan';
        
        // Get filter parameters
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $pelanggan = $this->input->get('pelanggan');
        
        // Get usage data with filters
        $data['penggunaan'] = $this->get_usage_report($bulan, $tahun, $pelanggan);
        $data['total_usage'] = $this->calculate_total_usage($data['penggunaan']);
        $data['average_usage'] = $this->calculate_average_usage($data['penggunaan']);
        
        // Get filter options
        $data['bulan_list'] = $this->get_bulan_list();
        $data['tahun_list'] = $this->get_tahun_list();
        $data['pelanggan_list'] = $this->get_pelanggan_list();
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/laporan_penggunaan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'penggunaan' => $data['penggunaan'],
            'total_usage' => $data['total_usage'],
            'average_usage' => $data['average_usage'],
            'bulan_list' => $data['bulan_list'],
            'tahun_list' => $data['tahun_list'],
            'pelanggan_list' => $data['pelanggan_list'],
            'filter_bulan' => $bulan,
            'filter_tahun' => $tahun,
            'filter_pelanggan' => $pelanggan
        ]);
    }

    // Helper methods for getting summary statistics
    private function get_summary_statistics() {
        $query = $this->db->query("
            SELECT 
                COUNT(DISTINCT p.id_pelanggan) as total_pelanggan,
                COUNT(DISTINCT t.id_tagihan) as total_tagihan,
                COUNT(DISTINCT CASE WHEN t.status = 'sudah_bayar' THEN t.id_tagihan END) as tagihan_lunas,
                COUNT(DISTINCT CASE WHEN t.status = 'belum_bayar' THEN t.id_tagihan END) as tagihan_belum_bayar,
                SUM(CASE WHEN pembayaran.total_bayar IS NOT NULL THEN pembayaran.total_bayar ELSE 0 END) as total_pembayaran,
                SUM(CASE WHEN pembayaran.biaya_admin IS NOT NULL THEN pembayaran.biaya_admin ELSE 0 END) as total_biaya_admin
            FROM pelanggan p
            LEFT JOIN tagihan t ON p.id_pelanggan = t.id_pelanggan
            LEFT JOIN pembayaran ON t.id_tagihan = pembayaran.id_tagihan
        ");
        
        return $query->row_array();
    }

    private function get_recent_payments() {
        $query = $this->db->query("
            SELECT 
                pembayaran.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                tagihan.bulan,
                tagihan.tahun,
                user.nama_admin
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            ORDER BY pembayaran.tanggal_pembayaran DESC
            LIMIT 5
        ");
        
        return $query->result_array();
    }

    private function get_monthly_statistics() {
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(pembayaran.tanggal_pembayaran, '%Y-%m') as bulan_tahun,
                COUNT(pembayaran.id_pembayaran) as jumlah_pembayaran,
                SUM(pembayaran.total_bayar) as total_pembayaran,
                SUM(pembayaran.biaya_admin) as total_biaya_admin
            FROM pembayaran
            WHERE pembayaran.tanggal_pembayaran >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(pembayaran.tanggal_pembayaran, '%Y-%m')
            ORDER BY bulan_tahun DESC
        ");
        
        return $query->result_array();
    }

    private function get_top_customers() {
        $query = $this->db->query("
            SELECT 
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                COUNT(tagihan.id_tagihan) as jumlah_tagihan,
                SUM(CASE WHEN tagihan.status = 'sudah_bayar' THEN 1 ELSE 0 END) as tagihan_lunas,
                SUM(CASE WHEN tagihan.status = 'belum_bayar' THEN 1 ELSE 0 END) as tagihan_belum_bayar
            FROM pelanggan
            LEFT JOIN tagihan ON pelanggan.id_pelanggan = tagihan.id_pelanggan
            GROUP BY pelanggan.id_pelanggan
            ORDER BY jumlah_tagihan DESC
            LIMIT 5
        ");
        
        return $query->result_array();
    }

    // Payment report methods
    private function get_payment_report($bulan = null, $tahun = null, $pelanggan = null) {
        $where_conditions = [];
        $params = [];
        
        if ($bulan) {
            $where_conditions[] = "tagihan.bulan = ?";
            $params[] = $bulan;
        }
        
        if ($tahun) {
            $where_conditions[] = "tagihan.tahun = ?";
            $params[] = $tahun;
        }
        
        if ($pelanggan) {
            $where_conditions[] = "pelanggan.id_pelanggan = ?";
            $params[] = $pelanggan;
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        
        $query = $this->db->query("
            SELECT 
                pembayaran.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                tagihan.bulan,
                tagihan.tahun,
                tagihan.jumlah_meter,
                user.nama_admin,
                tarif.daya,
                tarif.tarifperkwh
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            $where_clause
            ORDER BY pembayaran.tanggal_pembayaran DESC
        ", $params);
        
        return $query->result_array();
    }

    private function calculate_total_payment($payments) {
        return array_sum(array_column($payments, 'total_bayar'));
    }

    private function calculate_total_admin($payments) {
        return array_sum(array_column($payments, 'biaya_admin'));
    }

    // Bill report methods
    private function get_bill_report($status = null, $bulan = null, $tahun = null) {
        $where_conditions = [];
        $params = [];
        
        if ($status) {
            $where_conditions[] = "tagihan.status = ?";
            $params[] = $status;
        }
        
        if ($bulan) {
            $where_conditions[] = "tagihan.bulan = ?";
            $params[] = $bulan;
        }
        
        if ($tahun) {
            $where_conditions[] = "tagihan.tahun = ?";
            $params[] = $tahun;
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        
        $query = $this->db->query("
            SELECT 
                tagihan.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                tarif.daya,
                tarif.tarifperkwh,
                (tarif.tarifperkwh * tagihan.jumlah_meter) as total_tagihan
            FROM tagihan
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = tagihan.id_pelanggan
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            $where_clause
            ORDER BY tagihan.tahun DESC, tagihan.bulan DESC
        ", $params);
        
        return $query->result_array();
    }

    private function calculate_total_bill($bills) {
        return array_sum(array_column($bills, 'total_tagihan'));
    }

    private function calculate_total_paid($bills) {
        $paid_bills = array_filter($bills, function($bill) {
            return $bill['status'] == 'sudah_bayar';
        });
        return array_sum(array_column($paid_bills, 'total_tagihan'));
    }

    private function calculate_total_unpaid($bills) {
        $unpaid_bills = array_filter($bills, function($bill) {
            return $bill['status'] == 'belum_bayar';
        });
        return array_sum(array_column($unpaid_bills, 'total_tagihan'));
    }

    // Customer report methods
    private function get_customer_report($tarif = null, $status = null) {
        $where_conditions = [];
        $params = [];
        
        if ($tarif) {
            $where_conditions[] = "pelanggan.id_tarif = ?";
            $params[] = $tarif;
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        
        $query = $this->db->query("
            SELECT 
                pelanggan.*,
                tarif.daya,
                tarif.tarifperkwh,
                COUNT(tagihan.id_tagihan) as jumlah_tagihan,
                SUM(CASE WHEN tagihan.status = 'sudah_bayar' THEN 1 ELSE 0 END) as tagihan_lunas,
                SUM(CASE WHEN tagihan.status = 'belum_bayar' THEN 1 ELSE 0 END) as tagihan_belum_bayar
            FROM pelanggan
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            LEFT JOIN tagihan ON pelanggan.id_pelanggan = tagihan.id_pelanggan
            $where_clause
            GROUP BY pelanggan.id_pelanggan
            ORDER BY pelanggan.nama_pelanggan
        ", $params);
        
        return $query->result_array();
    }

    private function count_active_customers($customers) {
        return count(array_filter($customers, function($customer) {
            return $customer['jumlah_tagihan'] > 0;
        }));
    }

    private function count_inactive_customers($customers) {
        return count(array_filter($customers, function($customer) {
            return $customer['jumlah_tagihan'] == 0;
        }));
    }

    // Usage report methods
    private function get_usage_report($bulan = null, $tahun = null, $pelanggan = null) {
        $where_conditions = [];
        $params = [];
        
        if ($bulan) {
            $where_conditions[] = "penggunaan.bulan = ?";
            $params[] = $bulan;
        }
        
        if ($tahun) {
            $where_conditions[] = "penggunaan.tahun = ?";
            $params[] = $tahun;
        }
        
        if ($pelanggan) {
            $where_conditions[] = "penggunaan.id_pelanggan = ?";
            $params[] = $pelanggan;
        }
        
        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
        
        $query = $this->db->query("
            SELECT 
                penggunaan.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                tarif.daya,
                tarif.tarifperkwh,
                (penggunaan.meter_ahir - penggunaan.meter_awal) as penggunaan_kwh
            FROM penggunaan
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penggunaan.id_pelanggan
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            $where_clause
            ORDER BY penggunaan.tahun DESC, penggunaan.bulan DESC
        ", $params);
        
        return $query->result_array();
    }

    private function calculate_total_usage($usage_data) {
        return array_sum(array_column($usage_data, 'penggunaan_kwh'));
    }

    private function calculate_average_usage($usage_data) {
        if (empty($usage_data)) return 0;
        return array_sum(array_column($usage_data, 'penggunaan_kwh')) / count($usage_data);
    }

    // Filter options methods
    private function get_bulan_list() {
        return [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
    }

    private function get_tahun_list() {
        $current_year = date('Y');
        $years = [];
        for ($i = $current_year - 2; $i <= $current_year + 1; $i++) {
            $years[] = $i;
        }
        return $years;
    }

    private function get_pelanggan_list() {
        $query = $this->db->query("
            SELECT id_pelanggan, nama_pelanggan, nomor_kwh
            FROM pelanggan
            ORDER BY nama_pelanggan
        ");
        return $query->result_array();
    }

    private function get_tarif_list() {
        $query = $this->db->query("
            SELECT id_tarif, daya, tarifperkwh
            FROM tarif
            ORDER BY daya
        ");
        return $query->result_array();
    }
} 