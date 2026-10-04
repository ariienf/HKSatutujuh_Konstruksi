<?php

require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';
require_once BASE_PATH . '/app/models/AlatKonstruksi.php';
require_once BASE_PATH . '/app/models/Pengembalian.php';
require_once BASE_PATH . '/app/models/Pembayaran.php';

class PenyewaanController extends Controller {

    // ===========================
    // FORM SEWA ALAT
    // ===========================
    public function form($id_alat) {
        $this->requireLogin();

        $alatModel = new AlatKonstruksi();
        $alat = $alatModel->getByIdAlat($id_alat);

        if (!$alat || $alat['status_alat'] !== 'tersedia') {
            $this->setFlash('error', 'Alat tidak tersedia untuk disewa.');
            $this->redirect('home/katalog');
            return;
        }

        $this->render('penyewaan/form', [
            'alat'      => $alat,
            'pageTitle' => 'Form Sewa — ' . $alat['nama_alat'],
        ]);
    }

    // ===========================
    // PROSES SIMPAN PENYEWAAN
    // ===========================
    public function simpan() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home/katalog');
            return;
        }

        $id_alat        = (int) $this->post('id_alat');
        $tanggal_sewa   = $this->post('tanggal_sewa');
        $tanggal_kembali = $this->post('tanggal_kembali');
        $lokasi         = trim($this->post('lokasi_pengiriman'));
        $jumlah         = max(1, (int) $this->post('jumlah'));
        $id_pelanggan   = $_SESSION['pelanggan_id'];

        // Validasi
        if (empty($tanggal_sewa) || empty($tanggal_kembali) || empty($lokasi)) {
            $this->setFlash('error', 'Semua field wajib diisi.');
            $this->redirect('penyewaan/form/' . $id_alat);
            return;
        }

        if ($tanggal_kembali <= $tanggal_sewa) {
            $this->setFlash('error', 'Tanggal kembali harus setelah tanggal sewa.');
            $this->redirect('penyewaan/form/' . $id_alat);
            return;
        }

        $alatModel = new AlatKonstruksi();
        $alat = $alatModel->getByIdAlat($id_alat);

        if (!$alat || $alat['stok'] < $jumlah) {
            $this->setFlash('error', 'Stok alat tidak mencukupi.');
            $this->redirect('penyewaan/form/' . $id_alat);
            return;
        }

        // Validasi minimum sewa
        $lama_sewa = Penyewaan::hitungLamaSewa($tanggal_sewa, $tanggal_kembali);
        if ($lama_sewa < $alat['minimum_sewa']) {
            $this->setFlash('error', 'Minimum sewa alat ini adalah ' . $alat['minimum_sewa'] . ' hari.');
            $this->redirect('penyewaan/form/' . $id_alat);
            return;
        }

        // Hitung harga
        $subtotal    = Penyewaan::hitungTotalHarga($alat['biaya_sewa'], $jumlah, $lama_sewa);
        $total_harga = $subtotal;

        // Simpan penyewaan
        $penyewaanModel = new Penyewaan();
        $kode = $penyewaanModel->generateKode();

        $id_penyewaan = $penyewaanModel->buatPenyewaan([
            'kode_penyewaan'   => $kode,
            'id_pelanggan'     => $id_pelanggan,
            'tanggal_sewa'     => $tanggal_sewa,
            'tanggal_kembali'  => $tanggal_kembali,
            'lama_sewa'        => $lama_sewa,
            'lokasi_pengiriman' => $lokasi,
            'total_harga'      => $total_harga,
            'status_penyewaan' => 'menunggu',
        ]);

        if (!$id_penyewaan) {
            $this->setFlash('error', 'Gagal membuat penyewaan. Coba lagi.');
            $this->redirect('penyewaan/form/' . $id_alat);
            return;
        }

        // Simpan detail penyewaan
        $detailModel = new DetailPenyewaan();
        $detailModel->simpanDetail($id_penyewaan, $id_alat, $jumlah, $subtotal);

        // Kurangi stok alat
        $alatModel->kurangiStok($id_alat, $jumlah);
        $alatModel->updateStatus($id_alat);

        $this->setFlash('success', 'Penyewaan berhasil dibuat! Silakan lanjutkan pembayaran.');
        $this->redirect('pembayaran/form/' . $id_penyewaan);
    }

    // ===========================
    // RIWAYAT SEWA PELANGGAN
    // ===========================
    public function riwayat() {
        $this->requireLogin();

        $id_pelanggan       = $_SESSION['pelanggan_id'];
        $penyewaanModel     = new Penyewaan();
        $detailModel        = new DetailPenyewaan();
        $pengembalianModel  = new Pengembalian();
        $pembayaranModel    = new Pembayaran();

        $daftarSewa = $penyewaanModel->getByPelanggan($id_pelanggan);

        // Ambil detail alat & info denda untuk setiap penyewaan
        foreach ($daftarSewa as &$sewa) {
            $sewa['detail'] = $detailModel->getByPenyewaan($sewa['id_penyewaan']);

            $pengembalian    = $pengembalianModel->getByPenyewaan($sewa['id_penyewaan']);
            $sewa['denda']   = $pengembalian['denda'] ?? 0;
            $sewa['status_denda'] = null;
            if ($sewa['denda'] > 0) {
                $dendaBayar = $pembayaranModel->getDendaByPenyewaan($sewa['id_penyewaan']);
                $sewa['status_denda'] = $dendaBayar ? $dendaBayar['status_bayar'] : 'belum_ditagih';
            }
        }

        $this->render('penyewaan/riwayat', [
            'daftarSewa' => $daftarSewa,
            'pageTitle'  => 'Riwayat Sewa',
        ]);
    }

    // ===========================
    // DETAIL PENYEWAAN
    // ===========================
    public function detail($id_penyewaan) {
        $this->requireLogin();

        $id_pelanggan   = $_SESSION['pelanggan_id'];
        $penyewaanModel = new Penyewaan();

        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $id_pelanggan);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak ditemukan.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Blokir akses detail selama denda belum lunas/terverifikasi
        if ($this->adaDendaBelumLunas($id_penyewaan)) {
            return;
        }

        $detailModel = new DetailPenyewaan();
        $detail      = $detailModel->getByPenyewaan($id_penyewaan);

        $this->render('penyewaan/detail', [
            'sewa'      => $sewa,
            'detail'    => $detail,
            'pageTitle' => 'Detail Penyewaan — ' . $sewa['kode_penyewaan'],
        ]);
    }

    // ===========================
    // HELPER
    // ===========================
    // Cek apakah penyewaan ini punya denda yang belum lunas/terverifikasi.
    // Kalau ya, set flash & redirect ke riwayat, lalu kembalikan true supaya caller berhenti.
    private function adaDendaBelumLunas($id_penyewaan) {
        $pengembalianModel = new Pengembalian();
        $pengembalian = $pengembalianModel->getByPenyewaan($id_penyewaan);

        if (!$pengembalian || $pengembalian['denda'] <= 0) {
            return false;
        }

        $pembayaranModel = new Pembayaran();
        $dendaBayar = $pembayaranModel->getDendaByPenyewaan($id_penyewaan);

        if (!$dendaBayar) {
            $this->setFlash('error', 'Anda memiliki denda keterlambatan yang belum dibayar. Silakan bayar denda terlebih dahulu untuk mengakses halaman ini.');
            $this->redirect('penyewaan/riwayat');
            return true;
        }

        if ($dendaBayar['status_bayar'] !== 'lunas') {
            $this->setFlash('error', 'Pembayaran denda Anda sedang menunggu konfirmasi admin. Halaman ini akan tersedia setelah dikonfirmasi.');
            $this->redirect('penyewaan/riwayat');
            return true;
        }

        return false;
    }
}