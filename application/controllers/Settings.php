<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
     * Shows settings dashboard
     */
    public function index()
    {
        $data['page_title'] = 'Settings';
        $data['active_page'] = 'settings';
        
        // Get statistics for settings
        $data['tarif_count'] = $this->get_tarif_count();
        $data['level_count'] = $this->get_level_count();
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Tarif Settings
     */
    public function tarif()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric');
            $this->form_validation->set_rules('tarifperkwh', 'Tarif per KWH', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                // Insert tarif data
                $data = array(
                    'daya' => $this->input->post('daya'),
                    'tarifperkwh' => $this->input->post('tarifperkwh')
                );
                
                $this->db->insert('tarif', $data);
                
                $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan!');
                
                // Redirect to tarif settings
                redirect('settings/tarif');
            }
        }
        
        // Get all tarif
        $data['tarifs'] = $this->get_all_tarifs();
        $data['page_title'] = 'Settings - Tarif';
        $data['active_page'] = 'settings';
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings_tarif.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit Tarif
     */
    public function edit_tarif($id = NULL)
    {
        if ($id === NULL) {
            redirect('settings/tarif');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric');
            $this->form_validation->set_rules('tarifperkwh', 'Tarif per KWH', 'required|numeric');
            
            if ($this->form_validation->run() == TRUE) {
                // Update tarif data
                $data = array(
                    'daya' => $this->input->post('daya'),
                    'tarifperkwh' => $this->input->post('tarifperkwh')
                );
                
                $this->db->where('id_tarif', $id);
                $this->db->update('tarif', $data);
                
                $this->session->set_flashdata('success', 'Tarif berhasil diupdate!');
                
                // Redirect to tarif settings
                redirect('settings/tarif');
            }
        }
        
        // Get tarif data
        $data['tarif'] = $this->get_tarif_by_id($id);
        
        if (!$data['tarif']) {
            redirect('settings/tarif');
        }
        
        $data['page_title'] = 'Settings - Edit Tarif';
        $data['active_page'] = 'settings';
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings_tarif_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete Tarif
     */
    public function delete_tarif($id = NULL)
    {
        if ($id === NULL) {
            redirect('settings/tarif');
        }
        
        // Check if tarif is being used
        $this->db->where('id_tarif', $id);
        $pelanggan_count = $this->db->count_all_results('pelanggan');
        
        if ($pelanggan_count > 0) {
            $this->session->set_flashdata('error', 'Tarif tidak dapat dihapus karena masih digunakan oleh pelanggan!');
            redirect('settings/tarif');
        }
        
        // Delete tarif
        $this->db->where('id_tarif', $id);
        $this->db->delete('tarif');
        
        $this->session->set_flashdata('success', 'Tarif berhasil dihapus!');
        
        redirect('settings/tarif');
    }

    /**
     * Level Settings
     */
    public function level()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_level', 'Nama Level', 'required|is_unique[level.nama_level]');
            
            if ($this->form_validation->run() == TRUE) {
                // Insert level data
                $data = array(
                    'nama_level' => $this->input->post('nama_level')
                );
                
                $this->db->insert('level', $data);
                
                $this->session->set_flashdata('success', 'Level berhasil ditambahkan!');
                
                // Redirect to level settings
                redirect('settings/level');
            }
        }
        
        // Get all levels
        $data['levels'] = $this->get_all_levels();
        $data['page_title'] = 'Settings - Level';
        $data['active_page'] = 'settings';
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings_level.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Edit Level
     */
    public function edit_level($id = NULL)
    {
        if ($id === NULL) {
            redirect('settings/level');
        }
        
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('nama_level', 'Nama Level', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // Update level data
                $data = array(
                    'nama_level' => $this->input->post('nama_level')
                );
                
                $this->db->where('id_level', $id);
                $this->db->update('level', $data);
                
                $this->session->set_flashdata('success', 'Level berhasil diupdate!');
                
                // Redirect to level settings
                redirect('settings/level');
            }
        }
        
        // Get level data
        $data['level'] = $this->get_level_by_id($id);
        
        if (!$data['level']) {
            redirect('settings/level');
        }
        
        $data['page_title'] = 'Settings - Edit Level';
        $data['active_page'] = 'settings';
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings_level_form.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Delete Level
     */
    public function delete_level($id = NULL)
    {
        if ($id === NULL) {
            redirect('settings/level');
        }
        
        // Check if level is being used
        $this->db->where('id_level', $id);
        $user_count = $this->db->count_all_results('user');
        
        if ($user_count > 0) {
            $this->session->set_flashdata('error', 'Level tidak dapat dihapus karena masih digunakan oleh user!');
            redirect('settings/level');
        }
        
        // Delete level
        $this->db->where('id_level', $id);
        $this->db->delete('level');
        
        $this->session->set_flashdata('success', 'Level berhasil dihapus!');
        
        redirect('settings/level');
    }

    /**
     * System Settings
     */
    public function system()
    {
        if ($this->input->post()) {
            // Validate form
            $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required|numeric');
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('alamat_perusahaan', 'Alamat Perusahaan', 'required');
            $this->form_validation->set_rules('telepon_perusahaan', 'Telepon Perusahaan', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                // Update system settings (you might want to create a settings table)
                $this->session->set_flashdata('success', 'Pengaturan sistem berhasil diupdate!');
                
                // Redirect to system settings
                redirect('settings/system');
            }
        }
        
        // Get system settings (you might want to create a settings table)
        $data['page_title'] = 'Settings - Sistem';
        $data['active_page'] = 'settings';
        
        // Set the content view
        $data['content'] = 'application/views/pages/settings_system.php';
        
        // Load the view
        $this->load->view('layouts/main', $data);
    }

    /**
     * Get tarif count
     */
    private function get_tarif_count() {
        return $this->db->count_all('tarif');
    }

    /**
     * Get level count
     */
    private function get_level_count() {
        return $this->db->count_all('level');
    }

    /**
     * Get all tarifs
     */
    private function get_all_tarifs() {
        $query = $this->db->query("SELECT * FROM tarif ORDER BY daya");
        return $query->result_array();
    }

    /**
     * Get tarif by ID
     */
    private function get_tarif_by_id($id) {
        $query = $this->db->query("SELECT * FROM tarif WHERE id_tarif = ?", array($id));
        return $query->row_array();
    }

    /**
     * Get all levels
     */
    private function get_all_levels() {
        $query = $this->db->query("SELECT * FROM level ORDER BY nama_level");
        return $query->result_array();
    }

    /**
     * Get level by ID
     */
    private function get_level_by_id($id) {
        $query = $this->db->query("SELECT * FROM level WHERE id_level = ?", array($id));
        return $query->row_array();
    }
} 