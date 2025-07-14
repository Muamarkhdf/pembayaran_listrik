<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif extends CI_Controller {

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
     * Shows list of tariffs
     */
    public function index()
    {
        // Get all tariffs
        $data['tarif'] = $this->get_all_tariffs();
        $data['page_title'] = 'Data Tarif';
        $data['active_page'] = 'tarif';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tarif.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Add new tariff form
     */
    public function add()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric|is_unique[tarif.daya]');
            $this->form_validation->set_rules('tarifperkwh', 'Tarif per kWh', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                // Insert tariff data
                $data = array(
                    'daya' => $this->input->post('daya'),
                    'tarifperkwh' => $this->input->post('tarifperkwh')
                );
                
                $this->db->insert('tarif', $data);
                
                $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan!');
                
                // Redirect to tariff list
                redirect('tarif');
            }
        }
        
        $data['page_title'] = 'Tambah Tarif';
        $data['active_page'] = 'tarif';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tarif_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit tariff
     */
    public function edit($id = NULL)
    {
        if ($id === NULL) {
            redirect('tarif');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric');
            $this->form_validation->set_rules('tarifperkwh', 'Tarif per kWh', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                // Update tariff data
                $data = array(
                    'daya' => $this->input->post('daya'),
                    'tarifperkwh' => $this->input->post('tarifperkwh')
                );
                
                $this->db->where('id_tarif', $id);
                $this->db->update('tarif', $data);
                
                $this->session->set_flashdata('success', 'Tarif berhasil diupdate!');
                
                // Redirect to tariff list
                redirect('tarif');
            }
        }
        
        // Get tariff data
        $data['tarif'] = $this->get_tariff_by_id($id);
        
        if (!$data['tarif']) {
            redirect('tarif');
        }
        
        $data['page_title'] = 'Edit Tarif';
        $data['active_page'] = 'tarif';
        
        // Set the content view
        $data['content'] = 'application/views/pages/tarif_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete tariff
     */
    public function delete($id = NULL)
    {
        if ($id === NULL) {
            redirect('tarif');
        }
        
        // Check if tariff is used by customers
        $query = $this->db->query("SELECT COUNT(*) as total FROM pelanggan WHERE id_tarif = ?", array($id));
        $result = $query->row();
        
        if ($result->total > 0) {
            // Tariff is used by customers, cannot delete
            $this->session->set_flashdata('error', 'Tarif tidak dapat dihapus karena masih digunakan oleh pelanggan.');
        } else {
            // Delete tariff
            $this->db->where('id_tarif', $id);
            $this->db->delete('tarif');
            
            $this->session->set_flashdata('success', 'Tarif berhasil dihapus.');
        }
        
        redirect('tarif');
    }

    /**
     * Get all tariffs
     */
    private function get_all_tariffs() {
        $query = $this->db->query("
            SELECT t.*, 
                   COUNT(p.id_pelanggan) as total_pelanggan
            FROM tarif t
            LEFT JOIN pelanggan p ON t.id_tarif = p.id_tarif
            GROUP BY t.id_tarif
            ORDER BY t.daya
        ");
        
        return $query->result_array();
    }

    /**
     * Get tariff by ID
     */
    private function get_tariff_by_id($id) {
        $query = $this->db->query("SELECT * FROM tarif WHERE id_tarif = ?", array($id));
        return $query->row_array();
    }
} 