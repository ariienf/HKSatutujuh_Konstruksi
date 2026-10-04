<?php

require_once BASE_PATH . '/app/models/Pengembalian.php';
require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/AlatKonstruksi.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';

class PengembalianController extends Controller {

    // ===========================
    // FORM PENGEMBALIAN
    // ===========================
    public function form($id_penyewaan) {
        $this->requireLogin();

        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $_SESSION['pelanggan_id']);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak ditemukan.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Hanya bisa dikembalikan jika status aktif
        if ($sewa['status_penyewaan'] !== 'aktif') {
            $this->setFlash('error', 'Penyewaan ini belum aktif atau sudah selesai.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Cek sudah dikembalikan
        $pengembalianModel = new Pengembalian();
        if ($pengembalianModel->sudahDikembalikan($id_penyewaan)) {
            $this->setFlash('error', 'Alat sudah dikembalikan sebelumnya.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Hitung estimasi denda jika dikembalikan hari ini
        $today = date('Y-m-d');
        $estimasiDenda = Pengembalian::hitungDenda($sewa['tanggal_kembali'], $today, $sewa['total_harga']);
        $statusEstimasi = Pengembalian::tentukanStatus($sewa['tanggal_kembali'], $today);

        $detailModel = new DetailPenyewaan();
        $detail = $detailModel->getByPenyewaan($id_penyewaan);

        $this->render('pengembalian/form', [
            'sewa'            => $sewa,
            'detail'          => $detail,
            'estimasiDenda'   => $estimasiDenda,
            'statusEstimasi'  => $statusEstimasi,
            'today'           => $today,
            'pageTitle'       => 'Form Pengembalian',
        ]);
    }

    // ===========================
    // PROSES SIMPAN PENGEMBALIAN
    // ===========================
    public function simpan() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $id_penyewaan       = (int) $this->post('id_penyewaan');
        $tgl_pengembalian   = $this->post('tanggal_pengembalian');
        $keterangan         = trim($this->post('keterangan'));

        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $_SESSION['pelanggan_id']);

        if (!$sewa || $sewa['status_penyewaan'] !== 'aktif') {
            $this->setFlash('error', 'Data penyewaan tidak valid.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Hitung denda dan status
        $denda              = Pengembalian::hitungDenda($sewa['tanggal_kembali'], $tgl_pengembalian, $sewa['total_harga']);
        $status_pengembalian = Pengembalian::tentukanStatus($sewa['tanggal_kembali'], $tgl_pengembalian);

        // Simpan pengembalian
        $pengembalianModel = new Pengembalian();
        $id = $pengembalianModel->buatPengembalian([
            'id_penyewaan'        => $id_penyewaan,
            'tanggal_pengembalian' => $tgl_pengembalian,
            'status_pengembalian'  => $status_pengembalian,
            'denda'               => $denda,
            'keterangan'          => $keterangan,
        ]);

        if (!$id) {
            $this->setFlash('error', 'Gagal menyimpan pengembalian. Coba lagi.');
            $this->redirect('pengembalian/form/' . $id_penyewaan);
            return;
        }

        // Update status penyewaan jadi selesai
        $penyewaanModel->updateStatus($id_penyewaan, 'selesai');

        // Kembalikan stok alat
        $detailModel = new DetailPenyewaan();
        $detail = $detailModel->getByPenyewaan($id_penyewaan);
        $alatModel = new AlatKonstruksi();
        foreach ($detail as $d) {
            $alatModel->tambahStok($d['id_alat'], $d['jumlah']);
            $alatModel->updateStatus($d['id_alat']);
        }

        $this->setFlash('success', 'Pengembalian berhasil dicatat. Terima kasih!');
        $this->redirect('pengembalian/selesai/' . $id);
    }

    // ===========================
    // HALAMAN SELESAI
    // ===========================
    public function selesai($id_pengembalian) {
        $this->requireLogin();

        $pengembalianModel = new Pengembalian();
        $pengembalian = $pengembalianModel->queryOne(
            "SELECT pg.*, p.kode_penyewaan, p.tanggal_sewa, p.tanggal_kembali,
                    p.total_harga, p.lama_sewa, pl.nama_pelanggan
             FROM pengembalian pg
             JOIN penyewaan p ON pg.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE pg.id_pengembalian = ? AND p.id_pelanggan = ?",
            [$id_pengembalian, $_SESSION['pelanggan_id']]
        );

        if (!$pengembalian) {
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $this->render('pengembalian/selesai', [
            'pengembalian' => $pengembalian,
            'pageTitle'    => 'Pengembalian Selesai',
        ]);
    }
}
