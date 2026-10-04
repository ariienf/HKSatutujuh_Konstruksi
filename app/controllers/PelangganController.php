<?php

require_once BASE_PATH . '/app/models/Pelanggan.php';

class PelangganController extends Controller {

    // ===========================
    // PROFIL SAYA
    // ===========================
    public function profil() {
        $this->requireLogin();

        $pelangganModel = new Pelanggan();
        $id_pelanggan   = $_SESSION['pelanggan_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aksi = $this->post('aksi');

            if ($aksi === 'update_profil') {
                $nama = trim($this->post('nama_pelanggan'));

                $pelangganModel->updateProfil($id_pelanggan, [
                    'nama_pelanggan'  => $nama,
                    'no_hp'           => trim($this->post('no_hp')),
                    'alamat'          => trim($this->post('alamat')),
                    'nama_perusahaan' => trim($this->post('nama_perusahaan')),
                ]);

                $_SESSION['user_nama'] = $nama;
                $this->setFlash('success', 'Profil berhasil diperbarui.');
                $this->redirect('pelanggan/profil');
                return;
            }

            if ($aksi === 'update_password') {
                $pelanggan    = $pelangganModel->getOneWhere('id_pelanggan', $id_pelanggan);
                $passwordLama = $this->post('password_lama');
                $passwordBaru = $this->post('password_baru');
                $konfirmasi   = $this->post('konfirmasi_password');

                if (!password_verify($passwordLama, $pelanggan['password'])) {
                    $this->setFlash('error', 'Password lama tidak sesuai.');
                } elseif ($passwordBaru !== $konfirmasi) {
                    $this->setFlash('error', 'Konfirmasi password baru tidak cocok.');
                } elseif (strlen($passwordBaru) < 8) {
                    $this->setFlash('error', 'Password baru minimal 8 karakter.');
                } else {
                    $pelangganModel->updatePassword($id_pelanggan, $passwordBaru);
                    $this->setFlash('success', 'Password berhasil diubah.');
                }
                $this->redirect('pelanggan/profil');
                return;
            }
        }

        $pelanggan = $pelangganModel->getOneWhere('id_pelanggan', $id_pelanggan);
        $flash     = $this->getFlash();

        $this->render('pelanggan/profil', [
            'pageTitle' => 'Profil Saya',
            'pelanggan' => $pelanggan,
            'flash'     => $flash,
        ]);
    }
}
