<?php

require_once BASE_PATH . '/core/Model.php';

class Penyewaan extends Model {
    protected $table = 'penyewaan';

    // Generate kode penyewaan otomatis
    public function generateKode() {
        $prefix = 'SW-' . date('Ymd') . '-';
        $last = $this->queryOne(
            "SELECT kode_penyewaan FROM penyewaan WHERE kode_penyewaan LIKE ? ORDER BY id_penyewaan DESC LIMIT 1",
            [$prefix . '%']
        );
        if ($last) {
            $lastNum = (int) substr($last['kode_penyewaan'], -4);
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
        return $prefix . '0001';
    }

    // Buat penyewaan baru
    public function buatPenyewaan($data) {
        return $this->insert($data);
    }

    // Ambil semua penyewaan milik pelanggan
    public function getByPelanggan($id_pelanggan) {
        return $this->query(
            "SELECT p.*, py.status_bayar
             FROM penyewaan p
             LEFT JOIN pembayaran py ON p.id_penyewaan = py.id_penyewaan AND py.kode_transaksi NOT LIKE 'DND-%'
             WHERE p.id_pelanggan = ?
             ORDER BY p.created_at DESC",
            [$id_pelanggan]
        );
    }

    // Ambil detail penyewaan lengkap beserta alat
    public function getDetailLengkap($id_penyewaan) {
        return $this->queryOne(
            "SELECT p.*, pl.nama_pelanggan, pl.email, pl.no_hp
             FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.id_penyewaan = ?",
            [$id_penyewaan]
        );
    }

    // Ambil penyewaan berdasarkan ID dengan cek kepemilikan pelanggan
    public function getByIdAndPelanggan($id_penyewaan, $id_pelanggan) {
        return $this->queryOne(
            "SELECT * FROM penyewaan WHERE id_penyewaan = ? AND id_pelanggan = ?",
            [$id_penyewaan, $id_pelanggan]
        );
    }

    // Update status penyewaan
    public function updateStatus($id_penyewaan, $status) {
        return $this->update($id_penyewaan, ['status_penyewaan' => $status], 'id_penyewaan');
    }

    // Hitung lama sewa dalam hari
    public static function hitungLamaSewa($tgl_mulai, $tgl_kembali) {
        $mulai   = new DateTime($tgl_mulai);
        $kembali = new DateTime($tgl_kembali);
        $diff    = $mulai->diff($kembali);
        return max(1, $diff->days);
    }

    // Hitung total harga
    public static function hitungTotalHarga($biaya_sewa, $jumlah, $lama_sewa) {
        return $biaya_sewa * $jumlah * $lama_sewa;
    }
}