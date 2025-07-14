<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Penggunaan_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Tagihan_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['penggunaan'] = $this->Penggunaan_model->get_all_penggunaan();
        $data['page_title'] = 'Data Penggunaan';
        $data['active_page'] = 'penggunaan';
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/penggunaan.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'penggunaan' => $data['penggunaan']
        ]);
    }

    public function add() {
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['page_title'] = 'Tambah Penggunaan';
        $data['active_page'] = 'penggunaan';
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
            $this->form_validation->set_rules('meter_ahir', 'Meter Akhir', 'required|numeric');
            
            if ($this->form_validation->run() === TRUE) {
                $data_penggunaan = [
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'bulan' => $this->input->post('bulan'),
                    'tahun' => $this->input->post('tahun'),
                    'meter_awal' => $this->input->post('meter_awal'),
                    'meter_ahir' => $this->input->post('meter_ahir')
                ];
                
                // Check if meter akhir > meter awal
                if ($data_penggunaan['meter_ahir'] <= $data_penggunaan['meter_awal']) {
                    $this->session->set_flashdata('error', 'Meter akhir harus lebih besar dari meter awal!');
                    redirect('penggunaan/add');
                }
                
                // Check if usage already exists for this customer and period
                $existing = $this->Penggunaan_model->check_existing_usage(
                    $data_penggunaan['id_pelanggan'], 
                    $data_penggunaan['bulan'], 
                    $data_penggunaan['tahun']
                );
                
                if ($existing) {
                    $this->session->set_flashdata('error', 'Data penggunaan untuk pelanggan dan periode ini sudah ada!');
                    redirect('penggunaan/add');
                }
                
                // Start transaction
                $this->db->trans_start();
                
                // Insert usage data
                $result_penggunaan = $this->Penggunaan_model->insert($data_penggunaan);
                
                if ($result_penggunaan) {
                    // Get the inserted usage ID
                    $id_penggunaan = $this->db->insert_id();
                    
                    // Get customer data for tariff calculation
                    $pelanggan_data = $this->Pelanggan_model->get_by_id($data_penggunaan['id_pelanggan']);
                    
                    if ($pelanggan_data) {
                        // Calculate usage amount
                        $jumlah_meter = $data_penggunaan['meter_ahir'] - $data_penggunaan['meter_awal'];
                        
                        // Create tagihan data
                        $data_tagihan = [
                            'id_penggunaan' => $id_penggunaan,
                            'id_pelanggan' => $data_penggunaan['id_pelanggan'],
                            'bulan' => $data_penggunaan['bulan'],
                            'tahun' => $data_penggunaan['tahun'],
                            'jumlah_meter' => $jumlah_meter,
                            'status' => 'belum_bayar'
                        ];
                        
                        // Insert tagihan
                        $result_tagihan = $this->Tagihan_model->insert($data_tagihan);
                        
                        if ($result_tagihan) {
                            // Commit transaction
                            $this->db->trans_complete();
                            
                            if ($this->db->trans_status() === FALSE) {
                                // Transaction failed
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Gagal menambahkan data penggunaan dan tagihan!');
                            } else {
                                // Transaction successful
                                $this->session->set_flashdata('success', 'Data penggunaan dan tagihan berhasil ditambahkan!');
                                redirect('penggunaan');
                            }
                        } else {
                            // Rollback transaction
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error', 'Gagal membuat tagihan!');
                        }
                    } else {
                        // Rollback transaction
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
                    }
                } else {
                    // Rollback transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Gagal menambahkan data penggunaan!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/penggunaan_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'pelanggan' => $data['pelanggan']
        ]);
    }

    public function edit($id = null) {
        if (!$id) {
            redirect('penggunaan');
        }
        
        $data['penggunaan'] = $this->Penggunaan_model->get_by_id($id);
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['page_title'] = 'Edit Penggunaan';
        $data['active_page'] = 'penggunaan';
        
        if (!$data['penggunaan']) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan!');
            redirect('penggunaan');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric');
            $this->form_validation->set_rules('meter_ahir', 'Meter Akhir', 'required|numeric');
            
            if ($this->form_validation->run() === TRUE) {
                $data_penggunaan = [
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'bulan' => $this->input->post('bulan'),
                    'tahun' => $this->input->post('tahun'),
                    'meter_awal' => $this->input->post('meter_awal'),
                    'meter_ahir' => $this->input->post('meter_ahir')
                ];
                
                // Check if meter akhir > meter awal
                if ($data_penggunaan['meter_ahir'] <= $data_penggunaan['meter_awal']) {
                    $this->session->set_flashdata('error', 'Meter akhir harus lebih besar dari meter awal!');
                    redirect('penggunaan/edit/' . $id);
                }
                
                // Check if usage already exists for this customer and period (excluding current record)
                $existing = $this->Penggunaan_model->check_existing_usage_exclude(
                    $data_penggunaan['id_pelanggan'], 
                    $data_penggunaan['bulan'], 
                    $data_penggunaan['tahun'],
                    $id
                );
                
                if ($existing) {
                    $this->session->set_flashdata('error', 'Data penggunaan untuk pelanggan dan periode ini sudah ada!');
                    redirect('penggunaan/edit/' . $id);
                }
                
                // Start transaction
                $this->db->trans_start();
                
                // Update usage data
                $result_penggunaan = $this->Penggunaan_model->update($id, $data_penggunaan);
                
                if ($result_penggunaan) {
                    // Check if tagihan exists for this usage
                    $tagihan = $this->Tagihan_model->check_by_penggunaan($id);
                    
                    if ($tagihan) {
                        // Calculate new usage amount
                        $jumlah_meter = $data_penggunaan['meter_ahir'] - $data_penggunaan['meter_awal'];
                        
                        // Update tagihan data
                        $data_tagihan = [
                            'id_pelanggan' => $data_penggunaan['id_pelanggan'],
                            'bulan' => $data_penggunaan['bulan'],
                            'tahun' => $data_penggunaan['tahun'],
                            'jumlah_meter' => $jumlah_meter
                        ];
                        
                        // Update tagihan
                        $result_tagihan = $this->Tagihan_model->update($tagihan['id_tagihan'], $data_tagihan);
                        
                        if ($result_tagihan) {
                            // Commit transaction
                            $this->db->trans_complete();
                            
                            if ($this->db->trans_status() === FALSE) {
                                // Transaction failed
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Gagal mengupdate data penggunaan dan tagihan!');
                            } else {
                                // Transaction successful
                                $this->session->set_flashdata('success', 'Data penggunaan dan tagihan berhasil diupdate!');
                                redirect('penggunaan');
                            }
                        } else {
                            // Rollback transaction
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error', 'Gagal mengupdate tagihan!');
                        }
                    } else {
                        // No tagihan exists, create new one
                        $pelanggan_data = $this->Pelanggan_model->get_by_id($data_penggunaan['id_pelanggan']);
                        
                        if ($pelanggan_data) {
                            $jumlah_meter = $data_penggunaan['meter_ahir'] - $data_penggunaan['meter_awal'];
                            
                            $data_tagihan = [
                                'id_penggunaan' => $id,
                                'id_pelanggan' => $data_penggunaan['id_pelanggan'],
                                'bulan' => $data_penggunaan['bulan'],
                                'tahun' => $data_penggunaan['tahun'],
                                'jumlah_meter' => $jumlah_meter,
                                'status' => 'belum_bayar'
                            ];
                            
                            $result_tagihan = $this->Tagihan_model->insert($data_tagihan);
                            
                            if ($result_tagihan) {
                                // Commit transaction
                                $this->db->trans_complete();
                                
                                if ($this->db->trans_status() === FALSE) {
                                    // Transaction failed
                                    $this->db->trans_rollback();
                                    $this->session->set_flashdata('error', 'Gagal mengupdate data penggunaan dan membuat tagihan!');
                                } else {
                                    // Transaction successful
                                    $this->session->set_flashdata('success', 'Data penggunaan berhasil diupdate dan tagihan baru dibuat!');
                                    redirect('penggunaan');
                                }
                            } else {
                                // Rollback transaction
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Gagal membuat tagihan!');
                            }
                        } else {
                            // Rollback transaction
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan!');
                        }
                    }
                } else {
                    // Rollback transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Gagal mengupdate data penggunaan!');
                }
            }
        }
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/penggunaan_form.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'penggunaan' => $data['penggunaan'],
            'pelanggan' => $data['pelanggan']
        ]);
    }

    public function delete($id = null) {
        if (!$id) {
            redirect('penggunaan');
        }
        
        // Check if usage is used in tagihan
        $used_in_tagihan = $this->Penggunaan_model->check_used_in_tagihan($id);
        
        if ($used_in_tagihan) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak dapat dihapus karena sudah digunakan dalam tagihan!');
            redirect('penggunaan');
        }
        
        $result = $this->Penggunaan_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data penggunaan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data penggunaan!');
        }
        
        redirect('penggunaan');
    }

    public function detail($id = null) {
        if (!$id) {
            redirect('penggunaan');
        }
        
        $data['penggunaan'] = $this->Penggunaan_model->get_by_id($id);
        $data['page_title'] = 'Detail Penggunaan';
        $data['active_page'] = 'penggunaan';
        
        if (!$data['penggunaan']) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan!');
            redirect('penggunaan');
        }
        
        // Get related tagihan data
        $data['tagihan'] = $this->Tagihan_model->check_by_penggunaan($id);
        
        $this->load->view('layouts/main', [
            'content' => 'application/views/pages/penggunaan_detail.php',
            'page_title' => $data['page_title'],
            'active_page' => $data['active_page'],
            'penggunaan' => $data['penggunaan'],
            'tagihan' => $data['tagihan']
        ]);
    }
} 