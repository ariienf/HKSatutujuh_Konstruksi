<?php

require_once BASE_PATH . '/app/controllers/AdminController.php';

/**
 * PimpinanController
 * Akses sama dengan Administrator — extend langsung dari AdminController.
 * Pimpinan menggunakan semua fitur yang sama, hanya panel URL berbeda.
 * URL: /pimpinan/dashboard, /pimpinan/alat, dst.
 */
class PimpinanController extends AdminController {

    // Override cek akses khusus pimpinan
    private function requirePimpinan() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'pimpinan') {
            $this->redirect('auth/login');
        }
    }

    // Semua method (dashboard, alat, pelanggan, penyewaan, pembayaran, pengembalian, laporan)
    // diwarisi langsung dari AdminController.
    // Tidak perlu menduplikasi kode — cukup panggil parent::methodName()
    // karena view menggunakan $panelBase yang disesuaikan dengan $_SESSION['user_role'].
}