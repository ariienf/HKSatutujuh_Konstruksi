<?php

class Controller {

    // Load dan render view
    protected function render($view, $data = []) {
        // Ekstrak array data jadi variabel
        if (!empty($data)) {
            extract($data);
        }

        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View tidak ditemukan: {$view}.php");
        }

        // Load header layout
        include BASE_PATH . '/app/views/layouts/header.php';

        // Load view utama
        include $viewPath;

        // Load footer layout
        include BASE_PATH . '/app/views/layouts/footer.php';
    }

    // Render view tanpa layout (untuk AJAX / partial)
    protected function renderPartial($view, $data = []) {
        if (!empty($data)) {
            extract($data);
        }

        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View tidak ditemukan: {$view}.php");
        }

        include $viewPath;
    }

    // Redirect ke URL lain
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }

    // Kirim response JSON (untuk AJAX)
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Cek apakah pelanggan sudah login
    protected function isLoggedIn() {
        return isset($_SESSION['pelanggan_id']);
    }

    // Paksa login jika belum
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }

    // Ambil data dari method POST
    protected function post($key = null, $default = null) {
        if ($key === null) return $_POST;
        return $_POST[$key] ?? $default;
    }

    // Ambil data dari method GET
    protected function get($key = null, $default = null) {
        if ($key === null) return $_GET;
        return $_GET[$key] ?? $default;
    }

    // Flash message (untuk notifikasi setelah redirect)
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function getFlash() {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    // Generate & download PDF dari string HTML menggunakan mPDF
    protected function generatePDF($html, $filename) {
        $autoload = BASE_PATH . '/vendor/autoload.php';

        if (!file_exists($autoload)) {
            die('<div style="font-family:sans-serif;padding:2rem;background:#fee2e2;color:#991b1b;border-radius:8px;max-width:600px;margin:2rem auto;">
                <h3>mPDF Belum Terinstall</h3>
                <p>Jalankan perintah berikut di terminal pada folder project:</p>
                <code style="background:#1a1a1a;color:#fff;padding:0.5rem 1rem;border-radius:4px;display:block;margin:0.5rem 0;">
                    composer require mpdf/mpdf
                </code>
                <p>Setelah install, coba download lagi.</p>
            </div>');
        }

        require_once $autoload;

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 15,
            'margin_right'  => 15,
            'margin_bottom' => 15,
            'margin_left'   => 15,
            'default_font'  => 'Arial',
        ]);

        $mpdf->SetTitle('Laporan - HK Satu Tujuh');
        $mpdf->SetAuthor('HK Satu Tujuh');
        $mpdf->SetCreator('HK Satu Tujuh System');
        $mpdf->SetFooter('<div style="text-align:center;font-size:9px;color:#888;border-top:1px solid #ddd;padding-top:4px;">Halaman {PAGENO} dari {nbpg} — HK Satu Tujuh</div>');

        $mpdf->WriteHTML($html);

        $mpdf->Output($filename, 'D');
        exit;
    }
}
