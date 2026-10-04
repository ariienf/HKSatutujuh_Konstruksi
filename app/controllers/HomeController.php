<?php

require_once BASE_PATH . '/app/models/AlatKonstruksi.php';

class HomeController extends Controller {

    // ===========================
    // HALAMAN UTAMA
    // ===========================
    public function index() {
        $alatModel  = new AlatKonstruksi();
        $alatTerbaru = $alatModel->getTerbaru(6);
        $semuaJenis  = $alatModel->countByJenis();
        $totalAlat   = $alatModel->count();

        $this->render('home/index', [
            'alatTerbaru' => $alatTerbaru,
            'semuaJenis'  => $semuaJenis,
            'totalAlat'   => $totalAlat,
        ]);
    }

    // ===========================
    // HALAMAN TENTANG KAMI
    // ===========================
    public function tentangKami() {
        $alatModel = new AlatKonstruksi();
        $totalAlat = $alatModel->count();

        $this->render('home/tentang-kami', [
            'totalAlat' => $totalAlat,
        ]);
    }

    // ===========================
    // HALAMAN CARA SEWA
    // ===========================
    public function caraSewa() {
        $this->render('home/cara-sewa');
    }

    // ===========================
    // HALAMAN KATALOG
    // ===========================
    public function katalog() {
        $alatModel = new AlatKonstruksi();

        $keyword = trim($_GET['keyword'] ?? '');
        $jenis   = trim($_GET['jenis'] ?? '');

        if (!empty($keyword) || !empty($jenis)) {
            $daftarAlat = $alatModel->search($keyword, $jenis);
        } else {
            $daftarAlat = $alatModel->getAll('created_at DESC');
        }

        $semuaJenis = $alatModel->getAllJenis();

        $this->render('home/katalog', [
            'daftarAlat' => $daftarAlat,
            'semuaJenis' => $semuaJenis,
            'keyword'    => $keyword,
            'jenis'      => $jenis,
        ]);
    }

    // ===========================
    // DETAIL ALAT
    // ===========================
    public function detail($id) {
        $alatModel = new AlatKonstruksi();
        $alat = $alatModel->getByIdAlat($id);

        if (!$alat) {
            $this->setFlash('error', 'Alat tidak ditemukan.');
            $this->redirect('home/katalog');
            return;
        }

        // Alat sejenis sebagai rekomendasi
        $alatSejenis = $alatModel->getByJenis($alat['jenis_alat']);

        $this->render('home/detail', [
            'alat'       => $alat,
            'alatSejenis' => $alatSejenis,
        ]);
    }
}
