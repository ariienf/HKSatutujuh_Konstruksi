<?php

require_once BASE_PATH . '/core/Model.php';

class Pengembalian extends Model {
    protected $table = 'pengembalian';

    // Buat data pengembalian
    public function buatPengembalian($data) {
        return $this->insert($data);
    }

    // Ambil pengembalian berdasarkan id_penyewaan
    public function getByPenyewaan($id_penyewaan) {
        return $this->queryOne(
            "SELECT pg.*, p.tanggal_kembali, p.kode_penyewaan
             FROM pengembalian pg
             JOIN penyewaan p ON pg.id_penyewaan = p.id_penyewaan
             WHERE pg.id_penyewaan = ?",
            [$id_penyewaan]
        );
    }

    // Hitung denda keterlambatan
    // Denda = selisih hari × total harga sewa keseluruhan × 10%
    public static function hitungDenda($tgl_kembali_jadwal, $tgl_kembali_aktual, $total_harga) {
        $jadwal = new DateTime($tgl_kembali_jadwal);
        $aktual = new DateTime($tgl_kembali_aktual);

        if ($aktual <= $jadwal) return 0;

        $selisih = $jadwal->diff($aktual)->days;
        return $selisih * $total_harga * 0.1;
    }

    // Tentukan status pengembalian
    public static function tentukanStatus($tgl_kembali_jadwal, $tgl_kembali_aktual) {
        $jadwal = new DateTime($tgl_kembali_jadwal);
        $aktual = new DateTime($tgl_kembali_aktual);
        return $aktual <= $jadwal ? 'tepat_waktu' : 'terlambat';
    }

    // Cek apakah penyewaan sudah dikembalikan
    public function sudahDikembalikan($id_penyewaan) {
        $result = $this->queryOne(
            "SELECT id_pengembalian FROM pengembalian WHERE id_penyewaan = ?",
            [$id_penyewaan]
        );
        return $result ? true : false;
    }
}
