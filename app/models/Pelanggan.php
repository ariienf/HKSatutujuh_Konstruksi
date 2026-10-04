<?php

require_once BASE_PATH . '/core/Model.php';

class Pelanggan extends Model {
    protected $table = 'pelanggan';

    // Cari pelanggan berdasarkan email
    public function getByEmail($email) {
        return $this->queryOne(
            "SELECT * FROM pelanggan WHERE email = ? LIMIT 1",
            [$email]
        );
    }

    // Cek apakah email sudah terdaftar
    public function emailExists($email) {
        $result = $this->queryOne(
            "SELECT id_pelanggan FROM pelanggan WHERE email = ?",
            [$email]
        );
        return $result ? true : false;
    }

    // Register pelanggan baru
    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    // Login pelanggan
    public function login($email, $password) {
        $pelanggan = $this->getByEmail($email);
        if ($pelanggan && password_verify($password, $pelanggan['password'])) {
            return $pelanggan;
        }
        return false;
    }

    // Update profil
    public function updateProfil($id, $data) {
        return $this->update($id, $data, 'id_pelanggan');
    }

    // Update password
    public function updatePassword($id, $passwordBaru) {
        return $this->update($id, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT)
        ], 'id_pelanggan');
    }
}
