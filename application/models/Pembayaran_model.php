<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {
    protected $table = 'pembayaran';

    public function get_all_pembayaran() {
        $query = $this->db->query("
            SELECT 
                pembayaran.id_pembayaran,
                pembayaran.id_tagihan,
                pembayaran.id_pelanggan,
                pembayaran.tanggal_pembayaran,
                pembayaran.bulan_bayar,
                pembayaran.biaya_admin,
                pembayaran.total_bayar,
                pembayaran.id_user,
                COALESCE(pelanggan.nama_pelanggan, 'Tidak Diketahui') as nama_pelanggan,
                COALESCE(pelanggan.nomor_kwh, '-') as nomor_kwh,
                COALESCE(tagihan.bulan, '-') as bulan,
                COALESCE(tagihan.tahun, '-') as tahun,
                COALESCE(tagihan.jumlah_meter, 0) as jumlah_meter,
                COALESCE(user.nama_admin, 'Tidak Diketahui') as nama_admin,
                COALESCE(tarif.daya, 0) as daya,
                COALESCE(tarif.tarifperkwh, 0) as tarifperkwh,
                COALESCE((tarif.tarifperkwh * tagihan.jumlah_meter), 0) as total_tagihan
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            ORDER BY pembayaran.tanggal_pembayaran DESC
        ");
        return $query->result_array();
    }

    public function get_by_id($id) {
        $query = $this->db->query("
            SELECT 
                pembayaran.id_pembayaran,
                pembayaran.id_tagihan,
                pembayaran.id_pelanggan,
                pembayaran.tanggal_pembayaran,
                pembayaran.bulan_bayar,
                pembayaran.biaya_admin,
                pembayaran.total_bayar,
                pembayaran.id_user,
                COALESCE(pelanggan.nama_pelanggan, 'Tidak Diketahui') as nama_pelanggan,
                COALESCE(pelanggan.nomor_kwh, '-') as nomor_kwh,
                COALESCE(tagihan.bulan, '-') as bulan,
                COALESCE(tagihan.tahun, '-') as tahun,
                COALESCE(tagihan.jumlah_meter, 0) as jumlah_meter,
                COALESCE(user.nama_admin, 'Tidak Diketahui') as nama_admin,
                COALESCE(tarif.daya, 0) as daya,
                COALESCE(tarif.tarifperkwh, 0) as tarifperkwh,
                COALESCE((tarif.tarifperkwh * tagihan.jumlah_meter), 0) as total_tagihan
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            LEFT JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif
            WHERE pembayaran.id_pembayaran = ?
        ", array($id));
        return $query->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_pembayaran', $id);
        return $this->db->delete($this->table);
    }
} 