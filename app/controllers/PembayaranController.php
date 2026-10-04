<?php

require_once BASE_PATH . '/app/models/Pembayaran.php';
require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';
require_once BASE_PATH . '/app/models/Pengembalian.php';

class PembayaranController extends Controller {

    // ===========================
    // FORM PEMBAYARAN
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

        // Cek apakah sudah dibayar
        $pembayaranModel = new Pembayaran();
        if ($pembayaranModel->sudahDibayar($id_penyewaan)) {
            $this->setFlash('error', 'Penyewaan ini sudah dibayar.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Ambil detail alat
        $detailModel = new DetailPenyewaan();
        $detail = $detailModel->getByPenyewaan($id_penyewaan);

        $this->render('pembayaran/form', [
            'sewa'      => $sewa,
            'detail'    => $detail,
            'pageTitle' => 'Pembayaran — ' . $sewa['kode_penyewaan'],
        ]);
    }

    // ===========================
    // PROSES SIMPAN PEMBAYARAN
    // ===========================
    public function simpan() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $id_penyewaan = (int) $this->post('id_penyewaan');
        $metode_bayar = $this->post('metode_bayar');

        // Validasi kepemilikan
        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $_SESSION['pelanggan_id']);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak valid.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Validasi metode bayar
        $metodeDiizinkan = ['transfer_bank', 'qris', 'tunai'];
        if (!in_array($metode_bayar, $metodeDiizinkan)) {
            $this->setFlash('error', 'Metode pembayaran tidak valid.');
            $this->redirect('pembayaran/form/' . $id_penyewaan);
            return;
        }

        // Upload bukti pembayaran (wajib untuk transfer & qris)
        $bukti = null;
        if (in_array($metode_bayar, ['transfer_bank', 'qris'])) {
            if (empty($_FILES['bukti_pembayaran']['name'])) {
                $this->setFlash('error', 'Bukti pembayaran wajib diupload untuk metode transfer/QRIS.');
                $this->redirect('pembayaran/form/' . $id_penyewaan);
                return;
            }
            $bukti = $this->uploadBukti($_FILES['bukti_pembayaran']);
            if (!$bukti) {
                $this->setFlash('error', 'Gagal upload bukti. Format JPG/PNG, maks 2MB.');
                $this->redirect('pembayaran/form/' . $id_penyewaan);
                return;
            }
        }

        // Simpan pembayaran
        $pembayaranModel = new Pembayaran();
        $kode = $pembayaranModel->generateKode();

        $id_pembayaran = $pembayaranModel->buatPembayaran([
            'id_penyewaan'    => $id_penyewaan,
            'kode_transaksi'  => $kode,
            'total_bayar'     => $sewa['total_harga'],
            'metode_bayar'    => $metode_bayar,
            'status_bayar'    => $metode_bayar === 'tunai' ? 'menunggu' : 'menunggu',
            'tanggal_bayar'   => date('Y-m-d H:i:s'),
            'bukti_bayar' => $bukti,
        ]);

        if (!$id_pembayaran) {
            $this->setFlash('error', 'Gagal menyimpan pembayaran. Coba lagi.');
            $this->redirect('pembayaran/form/' . $id_penyewaan);
            return;
        }

        // Update status penyewaan jadi diproses
        $penyewaanModel->updateStatus($id_penyewaan, 'diproses');

        $this->setFlash('success', 'Pembayaran berhasil dikirim! Menunggu konfirmasi dari admin.');
        $this->redirect('pembayaran/sukses/' . $id_pembayaran);
    }

    // ===========================
    // FORM PEMBAYARAN DENDA
    // ===========================
    public function formDenda($id_penyewaan) {
        $this->requireLogin();

        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $_SESSION['pelanggan_id']);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak ditemukan.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Ambil data denda dari pengembalian
        $pengembalianModel = new Pengembalian();
        $pengembalian = $pengembalianModel->getByPenyewaan($id_penyewaan);

        if (!$pengembalian || $pengembalian['denda'] <= 0) {
            $this->setFlash('error', 'Tidak ada denda yang perlu dibayar untuk penyewaan ini.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Cek apakah denda sudah pernah ditagihkan/dibayar
        $pembayaranModel = new Pembayaran();
        $dendaExisting = $pembayaranModel->getDendaByPenyewaan($id_penyewaan);

        if ($dendaExisting) {
            $this->setFlash(
                $dendaExisting['status_bayar'] === 'lunas' ? 'success' : 'error',
                $dendaExisting['status_bayar'] === 'lunas'
                    ? 'Denda untuk penyewaan ini sudah lunas.'
                    : 'Pembayaran denda sudah dikirim dan sedang menunggu konfirmasi admin.'
            );
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $this->render('pembayaran/form-denda', [
            'sewa'         => $sewa,
            'pengembalian' => $pengembalian,
            'pageTitle'    => 'Bayar Denda — ' . $sewa['kode_penyewaan'],
        ]);
    }

    // ===========================
    // PROSES SIMPAN PEMBAYARAN DENDA
    // ===========================
    public function simpanDenda() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $id_penyewaan = (int) $this->post('id_penyewaan');
        $metode_bayar = $this->post('metode_bayar');

        // Validasi kepemilikan
        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $_SESSION['pelanggan_id']);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak valid.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Ambil nilai denda
        $pengembalianModel = new Pengembalian();
        $pengembalian = $pengembalianModel->getByPenyewaan($id_penyewaan);

        if (!$pengembalian || $pengembalian['denda'] <= 0) {
            $this->setFlash('error', 'Tidak ada denda yang perlu dibayar.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Cegah tagihan denda dobel
        $pembayaranModel = new Pembayaran();
        if ($pembayaranModel->getDendaByPenyewaan($id_penyewaan)) {
            $this->setFlash('error', 'Tagihan denda untuk penyewaan ini sudah ada.');
            $this->redirect('penyewaan/riwayat');
            return;
        }

        // Validasi metode bayar
        $metodeDiizinkan = ['transfer_bank', 'qris', 'tunai'];
        if (!in_array($metode_bayar, $metodeDiizinkan)) {
            $this->setFlash('error', 'Metode pembayaran tidak valid.');
            $this->redirect('pembayaran/formDenda/' . $id_penyewaan);
            return;
        }

        // Upload bukti pembayaran (wajib untuk transfer & qris)
        $bukti = null;
        if (in_array($metode_bayar, ['transfer_bank', 'qris'])) {
            if (empty($_FILES['bukti_pembayaran']['name'])) {
                $this->setFlash('error', 'Bukti pembayaran wajib diupload untuk metode transfer/QRIS.');
                $this->redirect('pembayaran/formDenda/' . $id_penyewaan);
                return;
            }
            $bukti = $this->uploadBukti($_FILES['bukti_pembayaran']);
            if (!$bukti) {
                $this->setFlash('error', 'Gagal upload bukti. Format JPG/PNG, maks 2MB.');
                $this->redirect('pembayaran/formDenda/' . $id_penyewaan);
                return;
            }
        }

        // Simpan sebagai baris pembayaran baru (kode berprefix DND-)
        $kode = $pembayaranModel->generateKodeDenda();

        $id_pembayaran = $pembayaranModel->buatPembayaran([
            'id_penyewaan'   => $id_penyewaan,
            'kode_transaksi' => $kode,
            'total_bayar'    => $pengembalian['denda'],
            'metode_bayar'   => $metode_bayar,
            'status_bayar'   => 'menunggu',
            'tanggal_bayar'  => date('Y-m-d H:i:s'),
            'bukti_bayar'    => $bukti,
        ]);

        if (!$id_pembayaran) {
            $this->setFlash('error', 'Gagal menyimpan pembayaran denda. Coba lagi.');
            $this->redirect('pembayaran/formDenda/' . $id_penyewaan);
            return;
        }

        $this->setFlash('success', 'Pembayaran denda berhasil dikirim! Menunggu konfirmasi dari admin.');
        $this->redirect('penyewaan/riwayat');
    }

    // ===========================
    // HALAMAN SUKSES
    // ===========================
    public function sukses($id_pembayaran) {
        $this->requireLogin();

        $pembayaranModel = new Pembayaran();
        $pembayaran = $pembayaranModel->getByIdPembayaran($id_pembayaran);

        if (!$pembayaran) {
            $this->redirect('penyewaan/riwayat');
            return;
        }

        $detailModel = new DetailPenyewaan();
        $detail = $detailModel->getByPenyewaan($pembayaran['id_penyewaan']);

        $this->render('pembayaran/sukses', [
            'pembayaran' => $pembayaran,
            'detail'     => $detail,
            'pageTitle'  => 'Pembayaran Berhasil',
        ]);
    }

    // ===========================
    // HELPER UPLOAD
    // ===========================
    private function uploadBukti($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > $maxSize) return false;

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'bukti_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $uploadDir = BASE_PATH . '/public/uploads/bukti/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }

        return false;
    }
}
