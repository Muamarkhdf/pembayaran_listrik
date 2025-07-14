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
        
        // If no payment data exists, add a test payment
        if (empty($data['pembayaran'])) {
            $this->add_test_payment();
            $data['pembayaran'] = $this->Pembayaran_model->get_all_pembayaran();
        }
        
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
                
                // Calculate payment details like in tagihan/bayar
                $tarif = $tagihan['tarifperkwh'];
                $jumlah_meter = $tagihan['jumlah_meter'];
                $biaya_admin = 10000; // Fixed admin fee like in tagihan/bayar
                $total_bayar = ($tarif * $jumlah_meter) + $biaya_admin;
                
                $data_pembayaran = [
                    'id_tagihan' => $id_tagihan,
                    'id_pelanggan' => $tagihan['id_pelanggan'],
                    'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                    'bulan_bayar' => $tagihan['bulan'],
                    'biaya_admin' => $biaya_admin,
                    'total_bayar' => $total_bayar,
                    'id_user' => $this->session->userdata('user_id')
                ];
                
                $result = $this->Pembayaran_model->insert($data_pembayaran);
                if ($result) {
                    $this->Tagihan_model->set_paid($id_tagihan);
                    $this->session->set_flashdata('success', 'Pembayaran berhasil diproses!');
                    redirect('pembayaran');
                } else {
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

    public function delete($id = null) {
        if (!$id) redirect('pembayaran');
        $pembayaran = $this->Pembayaran_model->get_by_id($id);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan!');
            redirect('pembayaran');
        }
        $this->Pembayaran_model->delete($id);
        $this->Tagihan_model->set_unpaid($pembayaran['id_tagihan']);
        $this->session->set_flashdata('success', 'Data pembayaran berhasil dihapus!');
        redirect('pembayaran');
    }

    public function detail($id = null) {
        if (!$id) redirect('pembayaran');
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
     * Add test payment for demonstration
     */
    private function add_test_payment() {
        // Get first available tagihan and user
        $tagihan = $this->db->get('tagihan')->row_array();
        $user = $this->db->get('user')->row_array();
        
        if ($tagihan && $user) {
            $test_data = [
                'id_tagihan' => $tagihan['id_tagihan'],
                'id_pelanggan' => $tagihan['id_pelanggan'],
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bulan_bayar' => $tagihan['bulan'],
                'biaya_admin' => 10000,
                'total_bayar' => 150000,
                'id_user' => $user['id_user']
            ];
            
            $this->db->insert('pembayaran', $test_data);
            
            // Update tagihan status
            $this->db->where('id_tagihan', $tagihan['id_tagihan']);
            $this->db->update('tagihan', ['status' => 'sudah_bayar']);
        }
    }
} 