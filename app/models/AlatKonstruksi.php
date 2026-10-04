<?php

require_once BASE_PATH . '/core/Model.php';

class AlatKonstruksi extends Model {
    protected $table = 'alat_konstruksi';

    // Ambil semua alat yang tersedia
    public function getAllTersedia() {
        return $this->query(
            "SELECT * FROM alat_konstruksi WHERE status_alat = 'tersedia' ORDER BY created_at DESC"
        );
    }

    // Ambil alat berdasarkan ID
    public function getByIdAlat($id) {
        return $this->queryOne(
            "SELECT * FROM alat_konstruksi WHERE id_alat = ?",
            [$id]
        );
    }

    // Ambil alat berdasarkan jenis/kategori
    public function getByJenis($jenis) {
        return $this->query(
            "SELECT * FROM alat_konstruksi WHERE jenis_alat = ? ORDER BY nama_alat ASC",
            [$jenis]
        );
    }

    // Cari alat berdasarkan nama atau jenis
    public function search($keyword, $jenis = '') {
        $sql = "SELECT * FROM alat_konstruksi WHERE nama_alat LIKE ?";
        $params = ['%' . $keyword . '%'];

        if (!empty($jenis)) {
            $sql .= " AND jenis_alat = ?";
            $params[] = $jenis;
        }

        $sql .= " ORDER BY nama_alat ASC";
        return $this->query($sql, $params);
    }

    // Ambil semua jenis alat (untuk dropdown kategori)
    public function getAllJenis() {
        return $this->query(
            "SELECT DISTINCT jenis_alat FROM alat_konstruksi ORDER BY jenis_alat ASC"
        );
    }

    // Ambil alat terbaru (untuk tampil di homepage)
    public function getTerbaru($limit = 6) {
        $limit = (int) $limit;
        return $this->query(
            "SELECT * FROM alat_konstruksi ORDER BY created_at DESC LIMIT {$limit}"
        );
    }

    // Hitung total alat per jenis
    public function countByJenis() {
        return $this->query(
            "SELECT jenis_alat, COUNT(*) as total FROM alat_konstruksi GROUP BY jenis_alat"
        );
    }

    // Kurangi stok saat disewa
    public function kurangiStok($id_alat, $jumlah) {
        return $this->execute(
            "UPDATE alat_konstruksi SET stok = stok - ? WHERE id_alat = ? AND stok >= ?",
            [$jumlah, $id_alat, $jumlah]
        );
    }

    // Tambah stok saat dikembalikan
    public function tambahStok($id_alat, $jumlah) {
        return $this->execute(
            "UPDATE alat_konstruksi SET stok = stok + ? WHERE id_alat = ?",
            [$jumlah, $id_alat]
        );
    }

    // Update status alat otomatis berdasarkan stok
    public function updateStatus($id_alat) {
        return $this->execute(
            "UPDATE alat_konstruksi SET status_alat = IF(stok > 0, 'tersedia', 'habis') WHERE id_alat = ?",
            [$id_alat]
        );
    }
}
