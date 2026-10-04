<?php

require_once BASE_PATH . '/app/models/Pelanggan.php';
require_once BASE_PATH . '/config/users.php';

class AuthController extends Controller {

    // ===========================
    // HALAMAN LOGIN
    // ===========================
    public function login() {
        // Jika sudah login (pelanggan maupun staff), redirect ke dashboard
        if (isset($_SESSION['user_role'])) {
            $this->redirectByRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($this->post('username'));
            $password = $this->post('password');

            // Cek staff dulu (hardcode)
            foreach (STAFF_USERS as $staff) {
                if ($staff['username'] === $username && $staff['password'] === $password) {
                    $_SESSION['user_id']   = $staff['username'];
                    $_SESSION['user_nama'] = $staff['nama'];
                    $_SESSION['user_role'] = $staff['role'];
                    $this->redirectByRole();
                    return;
                }
            }

            // Cek pelanggan di database
            $pelanggan = (new Pelanggan())->login($username, $password);
            if ($pelanggan) {
                $_SESSION['pelanggan_id']   = $pelanggan['id_pelanggan'];
                $_SESSION['user_nama']      = $pelanggan['nama_pelanggan'];
                $_SESSION['user_role']      = 'pelanggan';
                $_SESSION['user_email']     = $pelanggan['email'];
                $this->redirect('home');
                return;
            }

            // Login gagal
            $this->setFlash('error', 'Username/email atau password salah.');
        }

        $flash = $this->getFlash();
        $this->renderPartial('auth/login', ['flash' => $flash]);
    }

    // ===========================
    // HALAMAN REGISTER
    // ===========================
    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('home');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama       = trim($this->post('nama_pelanggan'));
            $email      = trim($this->post('email'));
            $password   = $this->post('password');
            $konfirmasi = $this->post('konfirmasi_password');
            $no_hp      = trim($this->post('no_hp'));
            $alamat     = trim($this->post('alamat'));
            $jk         = $this->post('jenis_kelamin');
            $perusahaan = trim($this->post('nama_perusahaan'));

            $pelangganModel = new Pelanggan();

            // Validasi
            if (empty($nama) || empty($email) || empty($password)) {
                $this->setFlash('error', 'Nama, email, dan password wajib diisi.');
                $this->redirect('auth/register');
                return;
            }

            if ($password !== $konfirmasi) {
                $this->setFlash('error', 'Konfirmasi password tidak cocok.');
                $this->redirect('auth/register');
                return;
            }

            if (strlen($password) < 8) {
                $this->setFlash('error', 'Password minimal 8 karakter.');
                $this->redirect('auth/register');
                return;
            }

            if ($pelangganModel->emailExists($email)) {
                $this->setFlash('error', 'Email sudah terdaftar, silakan login.');
                $this->redirect('auth/register');
                return;
            }

            // Upload foto KTP
            $foto_ktp = null;
            if (!empty($_FILES['foto_ktp']['name'])) {
                $foto_ktp = $this->uploadFoto($_FILES['foto_ktp']);
                if (!$foto_ktp) {
                    $this->setFlash('error', 'Gagal upload foto KTP. Format harus JPG/PNG, maks 2MB.');
                    $this->redirect('auth/register');
                    return;
                }
            }

            // Simpan ke database
            $id = $pelangganModel->register([
                'nama_pelanggan'  => $nama,
                'email'           => $email,
                'password'        => $password,
                'no_hp'           => $no_hp,
                'alamat'          => $alamat,
                'jenis_kelamin'   => $jk,
                'foto_ktp'        => $foto_ktp,
                'nama_perusahaan' => $perusahaan,
            ]);

            if ($id) {
                $this->setFlash('success', 'Registrasi berhasil! Silakan login.');
                $this->redirect('auth/login');
            } else {
                $this->setFlash('error', 'Registrasi gagal, coba lagi.');
                $this->redirect('auth/register');
            }
        }

        $flash = $this->getFlash();
        $this->renderPartial('auth/register', ['flash' => $flash]);
    }

    // ===========================
    // LOGOUT
    // ===========================
    public function logout() {
        $role = $_SESSION['user_role'] ?? null;
        session_destroy();

        if ($role && $role !== 'pelanggan') {
            $this->redirect('auth/backendLogin');
        } else {
            $this->redirect('auth/login');
        }
    }

    // ===========================
    // HALAMAN LOGIN BACKEND (STAFF)
    // ===========================
    public function backendLogin() {
        // Jika sudah login sebagai staff, redirect ke dashboard masing-masing
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'pelanggan') {
            $this->redirectByRole();
            return;
        }

        $flash = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($this->post('username'));
            $password = $this->post('password');

            foreach (STAFF_USERS as $staff) {
                if ($staff['username'] === $username && $staff['password'] === $password) {
                    $_SESSION['user_id']   = $staff['username'];
                    $_SESSION['user_nama'] = $staff['nama'];
                    $_SESSION['user_role'] = $staff['role'];
                    $this->redirectByRole();
                    return;
                }
            }

            $flash = ['type' => 'error', 'message' => 'Username atau password salah.'];
        }

        $this->renderPartial('auth/backend/login', ['flash' => $flash]);
    }

    // ===========================
    // HELPER
    // ===========================
    private function redirectByRole() {
        $role = $_SESSION['user_role'] ?? 'pelanggan';
        switch ($role) {
            case 'administrator':
                $this->redirect('admin/dashboard');
                break;
            case 'pimpinan':
                $this->redirect('pimpinan/dashboard');
                break;
            case 'bagian_penjualan':
                $this->redirect('penjualan/dashboard');
                break;
            default:
                $this->redirect('home');
        }
    }

    private function uploadFoto($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > $maxSize) return false;

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'ktp_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $uploadDir = BASE_PATH . '/public/uploads/ktp/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }

        return false;
    }
}
