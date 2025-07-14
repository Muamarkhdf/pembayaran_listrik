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

    public function get_by_pelanggan($id_pelanggan) {
        $query = $this->db->query("
            SELECT 
                pembayaran.*,
                COALESCE(pelanggan.nama_pelanggan, 'Tidak Diketahui') as nama_pelanggan,
                COALESCE(pelanggan.nomor_kwh, '-') as nomor_kwh,
                COALESCE(tagihan.bulan, '-') as bulan,
                COALESCE(tagihan.tahun, '-') as tahun,
                COALESCE(tagihan.jumlah_meter, 0) as jumlah_meter,
                COALESCE(user.nama_admin, 'Tidak Diketahui') as nama_admin
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            WHERE pembayaran.id_pelanggan = ?
            ORDER BY pembayaran.tanggal_pembayaran DESC
        ", array($id_pelanggan));
        return $query->result_array();
    }

    public function get_by_period($bulan, $tahun) {
        $query = $this->db->query("
            SELECT 
                pembayaran.*,
                COALESCE(pelanggan.nama_pelanggan, 'Tidak Diketahui') as nama_pelanggan,
                COALESCE(pelanggan.nomor_kwh, '-') as nomor_kwh,
                COALESCE(tagihan.bulan, '-') as bulan,
                COALESCE(tagihan.tahun, '-') as tahun,
                COALESCE(tagihan.jumlah_meter, 0) as jumlah_meter,
                COALESCE(user.nama_admin, 'Tidak Diketahui') as nama_admin
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            LEFT JOIN tagihan ON tagihan.id_tagihan = pembayaran.id_tagihan
            LEFT JOIN user ON user.id_user = pembayaran.id_user
            WHERE pembayaran.bulan_bayar = ? AND YEAR(pembayaran.tanggal_pembayaran) = ?
            ORDER BY pembayaran.tanggal_pembayaran DESC
        ", array($bulan, $tahun));
        return $query->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_pembayaran', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_pembayaran', $id);
        return $this->db->delete($this->table);
    }

    public function get_payment_statistics() {
        $query = $this->db->query("
            SELECT 
                COUNT(id_pembayaran) as total_pembayaran,
                SUM(total_bayar) as total_pendapatan,
                SUM(biaya_admin) as total_biaya_admin,
                AVG(total_bayar) as rata_rata_pembayaran,
                COUNT(DISTINCT id_pelanggan) as jumlah_pelanggan,
                MIN(tanggal_pembayaran) as tanggal_pertama,
                MAX(tanggal_pembayaran) as tanggal_terakhir
            FROM pembayaran
        ");
        return $query->row_array();
    }

    public function get_monthly_statistics($tahun) {
        $query = $this->db->query("
            SELECT 
                bulan_bayar,
                COUNT(id_pembayaran) as jumlah_pembayaran,
                SUM(total_bayar) as total_pendapatan,
                SUM(biaya_admin) as total_biaya_admin,
                AVG(total_bayar) as rata_rata_pembayaran
            FROM pembayaran
            WHERE YEAR(tanggal_pembayaran) = ?
            GROUP BY bulan_bayar
            ORDER BY FIELD(bulan_bayar, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')
        ", array($tahun));
        return $query->result_array();
    }

    public function get_top_paying_customers($limit = 10) {
        $query = $this->db->query("
            SELECT 
                pembayaran.id_pelanggan,
                pelanggan.nama_pelanggan,
                pelanggan.nomor_kwh,
                COUNT(pembayaran.id_pembayaran) as jumlah_pembayaran,
                SUM(pembayaran.total_bayar) as total_bayar
            FROM pembayaran
            LEFT JOIN pelanggan ON pelanggan.id_pelanggan = pembayaran.id_pelanggan
            GROUP BY pembayaran.id_pelanggan
            ORDER BY total_bayar DESC
            LIMIT ?
        ", array($limit));
        return $query->result_array();
    }

    public function check_existing_payment($id_tagihan) {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Get dynamic payment report with filter
     */
    public function get_payment_report($bulan = null, $tahun = null, $status = null) {
        $this->db->select('pembayaran.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tagihan.bulan, tagihan.tahun, tagihan.jumlah_meter, tagihan.status as status_tagihan');
        $this->db->from('pembayaran');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pembayaran.id_pelanggan', 'left');
        $this->db->join('tagihan', 'tagihan.id_tagihan = pembayaran.id_tagihan', 'left');
        if ($bulan) $this->db->where('tagihan.bulan', $bulan);
        if ($tahun) $this->db->where('tagihan.tahun', $tahun);
        if ($status) $this->db->where('tagihan.status', $status);
        $this->db->order_by('pembayaran.tanggal_pembayaran', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get payment statistics for dashboard
     */
    public function get_payment_stats($bulan = null, $tahun = null, $status = null) {
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'tagihan.id_tagihan = pembayaran.id_tagihan', 'left');
        if ($bulan) $this->db->where('tagihan.bulan', $bulan);
        if ($tahun) $this->db->where('tagihan.tahun', $tahun);
        if ($status) $this->db->where('tagihan.status', $status);
        $total_pembayaran = $this->db->count_all_results('', false);
        $this->db->select_sum('total_bayar');
        $total_pendapatan = $this->db->get()->row()->total_bayar;
        $this->db->select_avg('total_bayar');
        $rata_rata = $this->db->get('pembayaran')->row()->total_bayar;
        $this->db->select('COUNT(DISTINCT pembayaran.id_pelanggan) as pelanggan_aktif');
        $pelanggan_aktif = $this->db->get('pembayaran')->row()->pelanggan_aktif;
        return [
            'total_pembayaran' => $total_pembayaran,
            'total_pendapatan' => $total_pendapatan,
            'rata_rata' => $rata_rata,
            'pelanggan_aktif' => $pelanggan_aktif
        ];
    }
} 