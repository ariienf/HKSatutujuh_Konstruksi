<?php

require_once BASE_PATH . '/core/Model.php';

class DetailPenyewaan extends Model {
    protected $table = 'detail_penyewaan';

    // Simpan detail penyewaan
    public function simpanDetail($id_penyewaan, $id_alat, $jumlah, $subtotal) {
        return $this->insert([
            'id_penyewaan' => $id_penyewaan,
            'id_alat'      => $id_alat,
            'jumlah'       => $jumlah,
            'subtotal'     => $subtotal,
        ]);
    }

    // Ambil detail beserta info alat
    public function getByPenyewaan($id_penyewaan) {
        return $this->query(
            "SELECT dp.*, a.nama_alat, a.jenis_alat, a.biaya_sewa, a.gambar_alat
             FROM detail_penyewaan dp
             JOIN alat_konstruksi a ON dp.id_alat = a.id_alat
             WHERE dp.id_penyewaan = ?",
            [$id_penyewaan]
        );
    }
}