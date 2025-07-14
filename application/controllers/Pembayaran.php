<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pembayaran_model');
        $this->load->model('Tagihan_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('User_model');
        
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['pembayaran'] = $this->Pembayaran_model->get_all_pembayaran();
        $data['page_title'] = 'Data Pembayaran';
        $data['active_page'] = 'pembayaran';
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pembayaran.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function add() {
        $data['tagihan'] = $this->get_unpaid_bills_with_details();
        $data['page_title'] = 'Tambah Pembayaran';
        $data['active_page'] = 'pembayaran';
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('id_tagihan', 'Tagihan', 'required');
            
            if ($this->form_validation->run() === TRUE) {
                $id_tagihan = $this->input->post('id_tagihan');
                $tagihan = $this->get_bill_by_id($id_tagihan);
                
                if (!$tagihan || $tagihan['status'] == 'sudah_bayar') {
                    $this->session->set_flashdata('error', 'Tagihan tidak valid atau sudah dibayar!');
                    redirect('pembayaran/add');
                }
                
                // Get current user ID from session
                $user_id = $this->session->userdata('user_id');
                if (!$user_id) {
                    // If no user_id in session, get the first available user
                    $user = $this->User_model->get_by_id(1); // Default to admin
                    $user_id = $user ? $user['id_user'] : null;
                }
                
                // Calculate payment details
                $tarif = $tagihan['tarifperkwh'];
                $jumlah_meter = $tagihan['jumlah_meter'];
                $biaya_admin = 10000; // Fixed admin fee
                $total_bayar = ($tarif * $jumlah_meter) + $biaya_admin;
                
                $data_pembayaran = [
                    'id_tagihan' => $id_tagihan,
                    'id_pelanggan' => $tagihan['id_pelanggan'],
                    'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                    'bulan_bayar' => $tagihan['bulan'],
                    'biaya_admin' => $biaya_admin,
                    'total_bayar' => $total_bayar,
                    'id_user' => $user_id
                ];
                
                // Start transaction
                $this->db->trans_start();
                
                $result = $this->Pembayaran_model->insert($data_pembayaran);
                if ($result) {
                    // Update tagihan status
                    $this->Tagihan_model->set_paid($id_tagihan);
                    
                    // Commit transaction
                    $this->db->trans_complete();
                    
                    if ($this->db->trans_status() === FALSE) {
                        // Transaction failed
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('error', 'Gagal memproses pembayaran!');
                    } else {
                        // Transaction successful
                        $this->session->set_flashdata('success', 'Pembayaran berhasil diproses!');
                        redirect('pembayaran');
                    }
                } else {
                    // Rollback transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Gagal menyimpan pembayaran!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pembayaran_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'tagihan' => $data['tagihan']
        ]);
    }

    public function edit($id = null) {
        if (!$id) {
            redirect('pembayaran');
        }
        
        $data['pembayaran'] = $this->Pembayaran_model->get_by_id($id);
        $data['page_title'] = 'Edit Pembayaran';
        $data['active_page'] = 'pembayaran';
        
        if (!$data['pembayaran']) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan!');
            redirect('pembayaran');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required|numeric');
            $this->form_validation->set_rules('total_bayar', 'Total Bayar', 'required|numeric');
            
            if ($this->form_validation->run() === TRUE) {
                $data_update = [
                    'biaya_admin' => $this->input->post('biaya_admin'),
                    'total_bayar' => $this->input->post('total_bayar'),
                    'tanggal_pembayaran' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Pembayaran_model->update($id, $data_update);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Data pembayaran berhasil diupdate!');
                    redirect('pembayaran');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data pembayaran!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pembayaran_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function delete($id = null) {
        if (!$id) {
            redirect('pembayaran');
        }
        
        $pembayaran = $this->Pembayaran_model->get_by_id($id);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan!');
            redirect('pembayaran');
        }
        
        // Start transaction
        $this->db->trans_start();
        
        $result = $this->Pembayaran_model->delete($id);
        if ($result) {
            // Set tagihan back to unpaid
            $this->Tagihan_model->set_unpaid($pembayaran['id_tagihan']);
            
            // Commit transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                // Transaction failed
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal menghapus data pembayaran!');
            } else {
                // Transaction successful
                $this->session->set_flashdata('success', 'Data pembayaran berhasil dihapus!');
            }
        } else {
            // Rollback transaction
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Gagal menghapus data pembayaran!');
        }
        
        redirect('pembayaran');
    }

    public function detail($id = null) {
        if (!$id) {
            redirect('pembayaran');
        }
        
        $data['pembayaran'] = $this->Pembayaran_model->get_by_id($id);
        $data['page_title'] = 'Detail Pembayaran';
        $data['active_page'] = 'pembayaran';
        
        if (!$data['pembayaran']) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan!');
            redirect('pembayaran');
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pembayaran_detail.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function report() {
        $data['page_title'] = 'Laporan Pembayaran';
        $data['active_page'] = 'laporan';
        
        // Get filter parameters
        $bulan = $this->input->get('bulan') ?: date('F');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $status = $this->input->get('status') ?: '';
        
        // Get payment statistics
        $data['statistics'] = $this->get_payment_statistics($bulan, $tahun);
        $data['payments'] = $this->get_filtered_payments($bulan, $tahun, $status);
        $data['filter'] = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status
        ];
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/pembayaran_report.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'statistics' => $data['statistics'],
            'payments' => $data['payments'],
            'filter' => $data['filter']
        ]);
    }
    
    /**
     * Get unpaid bills with customer and tariff details
     */
    private function get_unpaid_bills_with_details() {
        $query = $this->db->query("
            SELECT t.*, p.nama_pelanggan, p.nomor_kwh, tr.daya, tr.tarifperkwh,
                   (tr.tarifperkwh * t.jumlah_meter) as total_tagihan,
                   (tr.tarifperkwh * t.jumlah_meter) + 10000 as total_bayar,
                   CASE 
                       WHEN t.status = 'sudah_bayar' THEN 'Sudah Bayar'
                       ELSE 'Belum Bayar'
                   END as status_text
            FROM tagihan t
            LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
            LEFT JOIN tarif tr ON p.id_tarif = tr.id_tarif
            WHERE t.status = 'belum_bayar'
            ORDER BY t.tahun DESC, t.bulan DESC
        ");
        
        return $query->result_array();
    }
    
    /**
     * Get bill by ID with details
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
     * Get payment statistics
     */
    private function get_payment_statistics($bulan = null, $tahun = null) {
        $where_clause = "";
        $params = [];
        
        if ($bulan && $tahun) {
            $where_clause = "WHERE pembayaran.bulan_bayar = ? AND YEAR(pembayaran.tanggal_pembayaran) = ?";
            $params = [$bulan, $tahun];
        }
        
        $query = $this->db->query("
            SELECT 
                COUNT(pembayaran.id_pembayaran) as total_pembayaran,
                SUM(pembayaran.total_bayar) as total_pendapatan,
                SUM(pembayaran.biaya_admin) as total_biaya_admin,
                AVG(pembayaran.total_bayar) as rata_rata_pembayaran,
                COUNT(DISTINCT pembayaran.id_pelanggan) as jumlah_pelanggan
            FROM pembayaran
            $where_clause
        ", $params);
        
        return $query->row_array();
    }
    
    /**
     * Get filtered payments
     */
    private function get_filtered_payments($bulan = null, $tahun = null, $status = null) {
        $where_conditions = [];
        $params = [];
        
        if ($bulan && $tahun) {
            $where_conditions[] = "pembayaran.bulan_bayar = ?";
            $where_conditions[] = "YEAR(pembayaran.tanggal_pembayaran) = ?";
            $params[] = $bulan;
            $params[] = $tahun;
        }
        
        if ($status) {
            $where_conditions[] = "tagihan.status = ?";
            $params[] = $status;
        }
        
        $where_clause = "";
        if (!empty($where_conditions)) {
            $where_clause = "WHERE " . implode(" AND ", $where_conditions);
        }
        
        $query = $this->db->query("
            SELECT 
                pembayaran.*,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                tagihan.bulan,
                tagihan.tahun,
                tagihan.jumlah_meter,
                tagihan.status as status_tagihan,
                user.nama_admin
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            $where_clause
            ORDER BY pembayaran.tanggal_pembayaran DESC
        ", $params);
        
        return $query->result_array();
    }
} 