<?php

require_once BASE_PATH . '/core/Model.php';

class Pembayaran extends Model {
    protected $table = 'pembayaran';

    // Generate kode transaksi otomatis
    public function generateKode() {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last = $this->queryOne(
            "SELECT kode_transaksi FROM pembayaran WHERE kode_transaksi LIKE ? ORDER BY id_pembayaran DESC LIMIT 1",
            [$prefix . '%']
        );
        if ($last) {
            $lastNum = (int) substr($last['kode_transaksi'], -4);
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
        return $prefix . '0001';
    }

    // Generate kode transaksi untuk denda keterlambatan
    public function generateKodeDenda() {
        $prefix = 'DND-' . date('Ymd') . '-';
        $last = $this->queryOne(
            "SELECT kode_transaksi FROM pembayaran WHERE kode_transaksi LIKE ? ORDER BY id_pembayaran DESC LIMIT 1",
            [$prefix . '%']
        );
        if ($last) {
            $lastNum = (int) substr($last['kode_transaksi'], -4);
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
        return $prefix . '0001';
    }

    // Buat data pembayaran baru
    public function buatPembayaran($data) {
        return $this->insert($data);
    }

    // Ambil pembayaran sewa (bukan denda) berdasarkan id_penyewaan
    public function getByPenyewaan($id_penyewaan) {
        return $this->queryOne(
            "SELECT * FROM pembayaran WHERE id_penyewaan = ? AND kode_transaksi NOT LIKE 'DND-%' ORDER BY id_pembayaran ASC LIMIT 1",
            [$id_penyewaan]
        );
    }

    // Ambil pembayaran denda berdasarkan id_penyewaan (kode_transaksi berprefix DND-)
    public function getDendaByPenyewaan($id_penyewaan) {
        return $this->queryOne(
            "SELECT * FROM pembayaran WHERE id_penyewaan = ? AND kode_transaksi LIKE 'DND-%' ORDER BY id_pembayaran DESC LIMIT 1",
            [$id_penyewaan]
        );
    }

    // Ambil pembayaran berdasarkan id
    public function getByIdPembayaran($id_pembayaran) {
        return $this->queryOne(
            "SELECT pb.*, p.kode_penyewaan, p.total_harga, p.tanggal_sewa,
                    p.tanggal_kembali, p.lama_sewa, p.lokasi_pengiriman,
                    pl.nama_pelanggan, pl.email, pl.no_hp
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE pb.id_pembayaran = ?",
            [$id_pembayaran]
        );
    }

    // Update status pembayaran + bukti
    public function konfirmasi($id_pembayaran, $bukti = null) {
        $data = [
            'status_bayar'  => 'lunas',
            'tanggal_bayar' => date('Y-m-d H:i:s'),
        ];
        if ($bukti) $data['bukti_bayar'] = $bukti;
        return $this->update($id_pembayaran, $data, 'id_pembayaran');
    }

    // Cek apakah penyewaan sudah dibayar
    public function sudahDibayar($id_penyewaan) {
        $result = $this->queryOne(
            "SELECT id_pembayaran FROM pembayaran WHERE id_penyewaan = ? AND status_bayar = 'lunas'",
            [$id_penyewaan]
        );
        return $result ? true : false;
    }
}
