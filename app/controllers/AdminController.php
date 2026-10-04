<?php

require_once BASE_PATH . '/app/models/AlatKonstruksi.php';
require_once BASE_PATH . '/app/models/Pelanggan.php';
require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';
require_once BASE_PATH . '/app/models/Pembayaran.php';
require_once BASE_PATH . '/app/models/Pengembalian.php';

class AdminController extends Controller {

    // Cek akses admin/pimpinan
    private function requireAdmin() {
        if (!isset($_SESSION['user_role']) ||
            !in_array($_SESSION['user_role'], ['administrator', 'pimpinan'])) {
            $this->redirect('auth/login');
        }
    }

    // ===========================
    // DASHBOARD
    // ===========================
    public function dashboard() {
        $this->requireAdmin();

        $db = getDB();

        $totalAlat      = (new AlatKonstruksi())->count();
        $totalPelanggan = (new Pelanggan())->count();

        $totalPenyewaan = $db->query("SELECT COUNT(*) as c FROM penyewaan")->fetch()['c'];
        $totalPendapatan = $db->query("SELECT COALESCE(SUM(total_bayar),0) as c FROM pembayaran WHERE status_bayar='lunas'")->fetch()['c'];
        $menungguKonfirmasi = $db->query("SELECT COUNT(*) as c FROM pembayaran WHERE status_bayar='menunggu'")->fetch()['c'];
        $sewaBerlangsung = $db->query("SELECT COUNT(*) as c FROM penyewaan WHERE status_penyewaan='aktif'")->fetch()['c'];

        // Grafik pendapatan harian, 30 hari terakhir (1 bulan terakhir)
        $pendapatanHarian = $db->query(
            "SELECT DATE(tanggal_bayar) as tgl, COALESCE(SUM(total_bayar),0) as total
               FROM pembayaran
               WHERE status_bayar='lunas'
                 AND tanggal_bayar >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
               GROUP BY DATE(tanggal_bayar)"
        )->fetchAll();
        $pendapatanPerTanggal = array_column($pendapatanHarian, 'total', 'tgl');

        $grafikData = [];
        for ($i = 29; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-{$i} day"));
            $grafikData[] = [
                'tanggal' => date('d M', strtotime($tgl)),
                'total'   => (float) ($pendapatanPerTanggal[$tgl] ?? 0),
            ];
        }

        // Penyewaan terbaru
        $sewaTerbaru = $db->query(
            "SELECT p.*, pl.nama_pelanggan
             FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             ORDER BY p.created_at DESC LIMIT 8"
        )->fetchAll();

        // Pembayaran menunggu konfirmasi
        $bayarMenunggu = $db->query(
            "SELECT pb.*, p.kode_penyewaan, pl.nama_pelanggan
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE pb.status_bayar = 'menunggu'
             ORDER BY pb.created_at DESC LIMIT 5"
        )->fetchAll();

        $this->renderAdmin('admin/dashboard', [
            'pageTitle'          => 'Dashboard',
            'totalAlat'          => $totalAlat,
            'totalPelanggan'     => $totalPelanggan,
            'totalPenyewaan'     => $totalPenyewaan,
            'totalPendapatan'    => $totalPendapatan,
            'menungguKonfirmasi' => $menungguKonfirmasi,
            'sewaBerlangsung'    => $sewaBerlangsung,
            'grafikData'         => $grafikData,
            'sewaTerbaru'        => $sewaTerbaru,
            'bayarMenunggu'      => $bayarMenunggu,
        ]);
    }

    // ===========================
    // ALAT — INDEX
    // ===========================
    public function alat() {
        $this->requireAdmin();
        $keyword = trim($_GET['keyword'] ?? '');
        $alatModel = new AlatKonstruksi();
        $daftarAlat = !empty($keyword)
            ? $alatModel->search($keyword)
            : $alatModel->getAll('created_at DESC');

        $this->renderAdmin('admin/alat/index', [
            'pageTitle'  => 'Kelola Alat',
            'daftarAlat' => $daftarAlat,
            'keyword'    => $keyword,
        ]);
    }

    // ALAT — FORM TAMBAH
    public function alatTambah() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_alat'    => trim($this->post('nama_alat')),
                'jenis_alat'   => trim($this->post('jenis_alat')),
                'deskripsi'    => trim($this->post('deskripsi')),
                'biaya_sewa'   => (float) $this->post('biaya_sewa'),
                'minimum_sewa' => (int) $this->post('minimum_sewa'),
                'stok'         => (int) $this->post('stok'),
                'status_alat'  => $this->post('stok') > 0 ? 'tersedia' : 'habis',
            ];
            // Upload gambar
            if (!empty($_FILES['gambar_alat']['name'])) {
                $gambar = $this->uploadGambar($_FILES['gambar_alat']);
                if ($gambar) $data['gambar_alat'] = $gambar;
            }
            (new AlatKonstruksi())->insert($data);
            $this->setFlash('success', 'Alat berhasil ditambahkan.');
            $this->redirect('admin/alat');
            return;
        }
        $this->renderAdmin('admin/alat/tambah', ['pageTitle' => 'Tambah Alat']);
    }

    // ALAT — FORM EDIT
    public function alatEdit($id) {
        $this->requireAdmin();
        $alatModel = new AlatKonstruksi();
        $alat = $alatModel->getByIdAlat($id);
        if (!$alat) { $this->redirect('admin/alat'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_alat'    => trim($this->post('nama_alat')),
                'jenis_alat'   => trim($this->post('jenis_alat')),
                'deskripsi'    => trim($this->post('deskripsi')),
                'biaya_sewa'   => (float) $this->post('biaya_sewa'),
                'minimum_sewa' => (int) $this->post('minimum_sewa'),
                'stok'         => (int) $this->post('stok'),
                'status_alat'  => $this->post('status_alat'),
            ];
            if (!empty($_FILES['gambar_alat']['name'])) {
                $gambar = $this->uploadGambar($_FILES['gambar_alat']);
                if ($gambar) $data['gambar_alat'] = $gambar;
            }
            $alatModel->update($id, $data, 'id_alat');
            $this->setFlash('success', 'Alat berhasil diupdate.');
            $this->redirect('admin/alat');
            return;
        }
        $this->renderAdmin('admin/alat/edit', ['pageTitle' => 'Edit Alat', 'alat' => $alat]);
    }

    // ALAT — HAPUS
    public function alatHapus($id) {
        $this->requireAdmin();
        (new AlatKonstruksi())->delete($id, 'id_alat');
        $this->setFlash('success', 'Alat berhasil dihapus.');
        $this->redirect('admin/alat');
    }

    // ===========================
    // PELANGGAN — INDEX
    // ===========================
    public function pelanggan() {
        $this->requireAdmin();
        $keyword = trim($_GET['keyword'] ?? '');
        $db = getDB();
        if (!empty($keyword)) {
            $stmt = $db->prepare("SELECT * FROM pelanggan WHERE nama_pelanggan LIKE ? OR email LIKE ? ORDER BY created_at DESC");
            $stmt->execute(['%'.$keyword.'%', '%'.$keyword.'%']);
            $daftarPelanggan = $stmt->fetchAll();
        } else {
            $daftarPelanggan = (new Pelanggan())->getAll('created_at DESC');
        }
        $this->renderAdmin('admin/pelanggan/index', [
            'pageTitle'       => 'Kelola Pelanggan',
            'daftarPelanggan' => $daftarPelanggan,
            'keyword'         => $keyword,
        ]);
    }

    // PELANGGAN — DETAIL
    public function pelangganDetail($id) {
        $this->requireAdmin();
        $pelanggan = (new Pelanggan())->getOneWhere('id_pelanggan', $id);
        if (!$pelanggan) { $this->redirect('admin/pelanggan'); return; }

        $db = getDB();
        $riwayat = $db->prepare(
            "SELECT p.*, pb.status_bayar FROM penyewaan p
             LEFT JOIN pembayaran pb ON p.id_penyewaan = pb.id_penyewaan AND pb.kode_transaksi NOT LIKE 'DND-%'
             WHERE p.id_pelanggan = ? ORDER BY p.created_at DESC"
        );
        $riwayat->execute([$id]);
        $riwayatSewa = $riwayat->fetchAll();

        $this->renderAdmin('admin/pelanggan/detail', [
            'pageTitle'   => 'Detail Pelanggan',
            'pelanggan'   => $pelanggan,
            'riwayatSewa' => $riwayatSewa,
        ]);
    }

    // PELANGGAN — EDIT
    public function pelangganEdit($id) {
        $this->requireAdmin();
        $pelangganModel = new Pelanggan();
        $pelanggan = $pelangganModel->getOneWhere('id_pelanggan', $id);
        if (!$pelanggan) { $this->redirect('admin/pelanggan'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pelangganModel->update($id, [
                'nama_pelanggan'  => trim($this->post('nama_pelanggan')),
                'no_hp'           => trim($this->post('no_hp')),
                'alamat'          => trim($this->post('alamat')),
                'nama_perusahaan' => trim($this->post('nama_perusahaan')),
            ], 'id_pelanggan');
            $this->setFlash('success', 'Data pelanggan berhasil diupdate.');
            $this->redirect('admin/pelanggan');
            return;
        }
        $this->renderAdmin('admin/pelanggan/edit', [
            'pageTitle' => 'Edit Pelanggan',
            'pelanggan' => $pelanggan,
        ]);
    }

    // ===========================
    // PENYEWAAN — INDEX
    // ===========================
    public function penyewaan() {
        $this->requireAdmin();
        $status  = $_GET['status'] ?? '';
        $db = getDB();
        $sql = "SELECT p.*, pl.nama_pelanggan FROM penyewaan p
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan";
        $params = [];
        if (!empty($status)) { $sql .= " WHERE p.status_penyewaan = ?"; $params[] = $status; }
        $sql .= " ORDER BY p.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $daftarSewa = $stmt->fetchAll();

        $this->renderAdmin('admin/penyewaan/index', [
            'pageTitle'  => 'Kelola Penyewaan',
            'daftarSewa' => $daftarSewa,
            'status'     => $status,
        ]);
    }

    // PENYEWAAN — DETAIL
    public function penyewaanDetail($id) {
        $this->requireAdmin();
        $db = getDB();
        $stmt = $db->prepare(
            "SELECT p.*, pl.nama_pelanggan, pl.email, pl.no_hp
             FROM penyewaan p JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.id_penyewaan = ?"
        );
        $stmt->execute([$id]);
        $sewa = $stmt->fetch();
        if (!$sewa) { $this->redirect('admin/penyewaan'); return; }

        $detail      = (new DetailPenyewaan())->getByPenyewaan($id);
        $pembayaran  = (new Pembayaran())->getByPenyewaan($id);
        $pengembalian = (new Pengembalian())->getByPenyewaan($id);

        $this->renderAdmin('admin/penyewaan/detail', [
            'pageTitle'    => 'Detail Penyewaan',
            'sewa'         => $sewa,
            'detail'       => $detail,
            'pembayaran'   => $pembayaran,
            'pengembalian' => $pengembalian,
        ]);
    }

    // PENYEWAAN — UPDATE STATUS
    public function penyewaanStatus($id) {
        $this->requireAdmin();
        $status = $this->post('status');
        $allowed = ['menunggu','diproses','aktif','selesai','dibatalkan'];
        if (in_array($status, $allowed)) {
            (new Penyewaan())->updateStatus($id, $status);
            $this->setFlash('success', 'Status penyewaan diupdate.');
        }
        $this->redirect('admin/penyewaanDetail/' . $id);
    }

    // ===========================
    // PEMBAYARAN — INDEX
    // ===========================
    public function pembayaran() {
        $this->requireAdmin();
        $status = $_GET['status'] ?? '';
        $db = getDB();
        $sql = "SELECT pb.*, p.kode_penyewaan, pl.nama_pelanggan
                FROM pembayaran pb
                JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan";
        $params = [];
        if (!empty($status)) { $sql .= " WHERE pb.status_bayar = ?"; $params[] = $status; }
        $sql .= " ORDER BY pb.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $daftarBayar = $stmt->fetchAll();

        $this->renderAdmin('admin/pembayaran/index', [
            'pageTitle'   => 'Kelola Pembayaran',
            'daftarBayar' => $daftarBayar,
            'status'      => $status,
        ]);
    }

    // PEMBAYARAN — KONFIRMASI
    public function pembayaranKonfirmasi($id) {
        $this->requireAdmin();
        $pembayaranModel = new Pembayaran();
        $bayar = $pembayaranModel->queryOne("SELECT * FROM pembayaran WHERE id_pembayaran = ?", [$id]);
        if (!$bayar) { $this->redirect('admin/pembayaran'); return; }

        $pembayaranModel->konfirmasi($id);

        // Pembayaran denda tidak mengubah status penyewaan (penyewaan sudah selesai)
        if (str_starts_with($bayar['kode_transaksi'], 'DND-')) {
            $this->setFlash('success', 'Pembayaran denda dikonfirmasi.');
        } else {
            (new Penyewaan())->updateStatus($bayar['id_penyewaan'], 'aktif');
            $this->setFlash('success', 'Pembayaran dikonfirmasi, penyewaan sekarang aktif.');
        }
        $this->redirect('admin/pembayaran');
    }

    // PEMBAYARAN — TOLAK
    public function pembayaranTolak($id) {
        $this->requireAdmin();
        $pembayaranModel = new Pembayaran();
        $bayar = $pembayaranModel->queryOne("SELECT * FROM pembayaran WHERE id_pembayaran = ?", [$id]);
        if (!$bayar) { $this->redirect('admin/pembayaran'); return; }

        $pembayaranModel->update($id, ['status_bayar' => 'gagal'], 'id_pembayaran');

        // Pembayaran denda tidak mengubah status penyewaan (penyewaan sudah selesai)
        if (str_starts_with($bayar['kode_transaksi'], 'DND-')) {
            $this->setFlash('error', 'Pembayaran denda ditolak.');
        } else {
            (new Penyewaan())->updateStatus($bayar['id_penyewaan'], 'dibatalkan');
            $this->setFlash('error', 'Pembayaran ditolak.');
        }
        $this->redirect('admin/pembayaran');
    }

    // ===========================
    // PENGEMBALIAN — INDEX
    // ===========================
    public function pengembalian() {
        $this->requireAdmin();
        $db = getDB();
        $daftarKembali = $db->query(
            "SELECT pg.*, p.kode_penyewaan, p.tanggal_kembali,
                    pl.nama_pelanggan
             FROM pengembalian pg
             JOIN penyewaan p ON pg.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             ORDER BY pg.created_at DESC"
        )->fetchAll();

        // Penyewaan aktif yang belum dikembalikan
        $belumKembali = $db->query(
            "SELECT p.*, pl.nama_pelanggan, pl.no_hp,
                    DATEDIFF(CURDATE(), p.tanggal_kembali) as hari_terlambat
             FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             LEFT JOIN pengembalian pg ON p.id_penyewaan = pg.id_penyewaan
             WHERE p.status_penyewaan = 'aktif' AND pg.id_pengembalian IS NULL
             ORDER BY p.tanggal_kembali ASC"
        )->fetchAll();

        $this->renderAdmin('admin/pengembalian/index', [
            'pageTitle'     => 'Kelola Pengembalian',
            'daftarKembali' => $daftarKembali,
            'belumKembali'  => $belumKembali,
        ]);
    }

    // PENGEMBALIAN — PROSES (oleh admin/pimpinan)
    public function pengembalianProses($id_penyewaan) {
        $this->requireAdmin();

        $db = getDB();
        $stmt = $db->prepare(
            "SELECT p.*, pl.nama_pelanggan FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.id_penyewaan = ? AND p.status_penyewaan = 'aktif'"
        );
        $stmt->execute([$id_penyewaan]);
        $sewa = $stmt->fetch();

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak valid.');
            $this->redirect('admin/pengembalian');
            return;
        }

        // Cek sudah dikembalikan
        if ((new Pengembalian())->sudahDikembalikan($id_penyewaan)) {
            $this->setFlash('error', 'Alat sudah dikembalikan sebelumnya.');
            $this->redirect('admin/pengembalian');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tgl_pengembalian = $this->post('tanggal_pengembalian');
            $keterangan       = trim($this->post('keterangan'));

            $denda               = Pengembalian::hitungDenda($sewa['tanggal_kembali'], $tgl_pengembalian, $sewa['total_harga']);
            $status_pengembalian = Pengembalian::tentukanStatus($sewa['tanggal_kembali'], $tgl_pengembalian);

            $pengembalianModel = new Pengembalian();
            $pengembalianModel->buatPengembalian([
                'id_penyewaan'         => $id_penyewaan,
                'tanggal_pengembalian' => $tgl_pengembalian,
                'status_pengembalian'  => $status_pengembalian,
                'denda'                => $denda,
                'keterangan'           => $keterangan,
            ]);

            // Update status penyewaan
            (new Penyewaan())->updateStatus($id_penyewaan, 'selesai');

            // Kembalikan stok alat
            $detailModel = new DetailPenyewaan();
            $detail      = $detailModel->getByPenyewaan($id_penyewaan);
            $alatModel   = new AlatKonstruksi();
            foreach ($detail as $d) {
                $alatModel->tambahStok($d['id_alat'], $d['jumlah']);
                $alatModel->updateStatus($d['id_alat']);
            }

            $this->setFlash('success', 'Pengembalian berhasil diproses.');
            $this->redirect('admin/pengembalian');
            return;
        }

        $detail        = (new DetailPenyewaan())->getByPenyewaan($id_penyewaan);
        $today         = date('Y-m-d');
        $estimasiDenda = Pengembalian::hitungDenda($sewa['tanggal_kembali'], $today, $sewa['total_harga']);
        $statusEstimasi = Pengembalian::tentukanStatus($sewa['tanggal_kembali'], $today);

        $this->renderAdmin('admin/pengembalian/proses', [
            'pageTitle'      => 'Proses Pengembalian',
            'sewa'           => $sewa,
            'detail'         => $detail,
            'today'          => $today,
            'estimasiDenda'  => $estimasiDenda,
            'statusEstimasi' => $statusEstimasi,
        ]);
    }

    // ===========================
    // LAPORAN
    // ===========================
    public function laporan() {
        $this->requireAdmin();

        $dari   = $_GET['dari']   ?? date('Y-m-01');
        $sampai = $_GET['sampai'] ?? date('Y-m-t');
        $db = getDB();

        // Total pendapatan periode
        $pendapatan = $db->prepare(
            "SELECT COALESCE(SUM(total_bayar),0) as total FROM pembayaran
             WHERE status_bayar='lunas' AND DATE(tanggal_bayar) BETWEEN ? AND ?"
        );
        $pendapatan->execute([$dari, $sampai]);
        $totalPendapatan = $pendapatan->fetch()['total'];

        // Total penyewaan periode
        $totalSewa = $db->prepare(
            "SELECT COUNT(*) as total FROM penyewaan
             WHERE DATE(created_at) BETWEEN ? AND ?"
        );
        $totalSewa->execute([$dari, $sampai]);
        $totalPenyewaan = $totalSewa->fetch()['total'];

        // Alat terbanyak disewa
        $alatPopuler = $db->prepare(
            "SELECT a.nama_alat, a.jenis_alat, SUM(dp.jumlah) as total_disewa
             FROM detail_penyewaan dp
             JOIN alat_konstruksi a ON dp.id_alat = a.id_alat
             JOIN penyewaan p ON dp.id_penyewaan = p.id_penyewaan
             WHERE DATE(p.created_at) BETWEEN ? AND ?
             GROUP BY dp.id_alat ORDER BY total_disewa DESC LIMIT 5"
        );
        $alatPopuler->execute([$dari, $sampai]);
        $alatTerpopuler = $alatPopuler->fetchAll();

        // Daftar transaksi periode
        $transaksi = $db->prepare(
            "SELECT pb.*, p.kode_penyewaan, pl.nama_pelanggan, p.lama_sewa
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE DATE(pb.created_at) BETWEEN ? AND ?
             ORDER BY pb.created_at DESC"
        );
        $transaksi->execute([$dari, $sampai]);
        $daftarTransaksi = $transaksi->fetchAll();

        // Total denda periode
        $denda = $db->prepare(
            "SELECT COALESCE(SUM(denda),0) as total FROM pengembalian
             WHERE DATE(created_at) BETWEEN ? AND ?"
        );
        $denda->execute([$dari, $sampai]);
        $totalDenda = $denda->fetch()['total'];

        if (isset($_GET['export'])) {
            $html = $this->buildLaporanHTML(
                $dari, $sampai, $totalPendapatan, $totalPenyewaan,
                $alatTerpopuler, $daftarTransaksi, $totalDenda
            );
            $this->generatePDF($html, 'Laporan-' . $dari . '_sd_' . $sampai . '.pdf');
            return;
        }

        $this->renderAdmin('admin/laporan/index', [
            'pageTitle'       => 'Laporan',
            'dari'            => $dari,
            'sampai'          => $sampai,
            'totalPendapatan' => $totalPendapatan,
            'totalPenyewaan'  => $totalPenyewaan,
            'alatTerpopuler'  => $alatTerpopuler,
            'daftarTransaksi' => $daftarTransaksi,
            'totalDenda'      => $totalDenda,
        ]);
    }

    // Susun HTML laporan untuk dijadikan PDF
    private function buildLaporanHTML($dari, $sampai, $totalPendapatan, $totalPenyewaan, $alatTerpopuler, $daftarTransaksi, $totalDenda) {
        $periode = date('d M Y', strtotime($dari)) . ' &ndash; ' . date('d M Y', strtotime($sampai));

        $rowsAlat = '';
        if (empty($alatTerpopuler)) {
            $rowsAlat = '<tr><td colspan="4" style="text-align:center;color:#888;">Tidak ada data</td></tr>';
        } else {
            foreach ($alatTerpopuler as $i => $a) {
                $rowsAlat .= '<tr>
                    <td class="text-center">' . ($i + 1) . '</td>
                    <td>' . htmlspecialchars($a['nama_alat']) . '</td>
                    <td>' . htmlspecialchars($a['jenis_alat']) . '</td>
                    <td class="text-right">' . $a['total_disewa'] . '×</td>
                </tr>';
            }
        }

        $rowsTransaksi = '';
        if (empty($daftarTransaksi)) {
            $rowsTransaksi = '<tr><td colspan="6" style="text-align:center;color:#888;">Tidak ada transaksi</td></tr>';
        } else {
            foreach ($daftarTransaksi as $i => $t) {
                $rowsTransaksi .= '<tr>
                    <td class="text-center">' . ($i + 1) . '</td>
                    <td>' . htmlspecialchars($t['kode_transaksi']) . '</td>
                    <td>' . htmlspecialchars($t['nama_pelanggan']) . '</td>
                    <td>' . ucfirst(str_replace('_', ' ', $t['metode_bayar'])) . '</td>
                    <td class="text-right">Rp ' . number_format($t['total_bayar'], 0, ',', '.') . '</td>
                    <td class="text-center">' . ucfirst($t['status_bayar']) . '</td>
                </tr>';
            }
        }

        return $this->laporanStyle() . '
            <div class="header">
                <img src="' . BASE_PATH . '/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
                <div class="brand">HK Satu Tujuh</div>
                <div class="title">Laporan Transaksi</div>
            </div>
            <table class="meta">
                <tr>
                    <td>Periode: <b>' . $periode . '</b></td>
                    <td class="text-right">Dicetak: ' . date('d M Y H:i') . '</td>
                </tr>
            </table>

            <table class="summary">
                <tr>
                    <td class="card card-green"><span class="label">Total Pendapatan</span><span class="value">Rp ' . number_format($totalPendapatan, 0, ',', '.') . '</span></td>
                    <td class="card card-blue"><span class="label">Total Penyewaan</span><span class="value">' . $totalPenyewaan . '</span></td>
                    <td class="card card-red"><span class="label">Total Denda</span><span class="value">Rp ' . number_format($totalDenda, 0, ',', '.') . '</span></td>
                </tr>
            </table>

            <div class="section-title">Alat Terpopuler</div>
            <table>
                <thead><tr><th style="width:8%;">#</th><th>Nama Alat</th><th>Jenis</th><th style="width:20%;" class="text-right">Total Disewa</th></tr></thead>
                <tbody>' . $rowsAlat . '</tbody>
            </table>

            <div class="section-title">Daftar Transaksi</div>
            <table>
                <thead><tr><th style="width:6%;">#</th><th>Kode</th><th>Pelanggan</th><th>Metode</th><th class="text-right">Total</th><th class="text-center">Status</th></tr></thead>
                <tbody>' . $rowsTransaksi . '</tbody>
            </table>
        </body></html>';
    }

    // CSS bersama untuk laporan PDF
    private function laporanStyle() {
        return '<html><head><meta charset="utf-8"><style>
            body{font-family:Arial,sans-serif;font-size:11.5px;color:#222;}
            .header{text-align:center;border-bottom:2px solid #f97316;padding-bottom:10px;margin-bottom:12px;}
            .header img{height:44px;width:44px;object-fit:cover;border-radius:8px;margin-bottom:6px;}
            .header .brand{font-size:20px;font-weight:800;color:#1f2937;}
            .header .title{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#f97316;margin-top:4px;}
            .meta{width:100%;font-size:10.5px;color:#555;margin-bottom:16px;}
            .meta td{padding:0;}
            table{width:100%;border-collapse:collapse;}
            .summary{margin-bottom:18px;}
            .summary td{border:none;padding:0 6px;}
            .summary .card{border:1px solid #e5e7eb;border-left:4px solid #999;border-radius:3px;padding:8px 12px;}
            .summary .card-green{border-left-color:#22c55e;}
            .summary .card-blue{border-left-color:#3b82f6;}
            .summary .card-red{border-left-color:#ef4444;}
            .summary .label{display:block;font-size:9.5px;color:#666;text-transform:uppercase;letter-spacing:0.4px;}
            .summary .value{display:block;font-weight:bold;font-size:15px;margin-top:3px;}
            .section-title{font-size:12px;font-weight:700;color:#fff;background:#374151;padding:5px 10px;margin:14px 0 0;}
            th,td{border:1px solid #ddd;padding:6px 8px;text-align:left;font-size:10.5px;}
            th{background:#f3f4f6;font-weight:700;}
            tbody tr:nth-child(even){background:#f9fafb;}
            .text-right{text-align:right;}
            .text-center{text-align:center;}
        </style></head><body>';
    }

    // ===========================
    // HELPER
    // ===========================
    private function renderAdmin($view, $data = []) {
        if (!empty($data)) extract($data);
        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';
        if (!file_exists($viewPath)) die("View tidak ditemukan: $view");

        include BASE_PATH . '/app/views/admin/layouts/header.php';
        include $viewPath;
        include BASE_PATH . '/app/views/admin/layouts/footer.php';
    }

    private function uploadGambar($file) {
        $allowed = ['image/jpeg','image/png','image/jpg','image/webp'];
        if (!in_array($file['type'], $allowed)) return false;
        if ($file['size'] > 2 * 1024 * 1024) return false;
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'alat_' . time() . '_' . rand(100,999) . '.' . $ext;
        $dir      = BASE_PATH . '/public/uploads/alat/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        return move_uploaded_file($file['tmp_name'], $dir . $filename) ? $filename : false;
    }
}