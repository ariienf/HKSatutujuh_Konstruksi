<?php

require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';
require_once BASE_PATH . '/app/models/Pembayaran.php';
require_once BASE_PATH . '/app/models/Pengembalian.php';
require_once BASE_PATH . '/app/models/AlatKonstruksi.php';

class PenjualanController extends Controller {

    // Cek akses bagian penjualan
    private function requirePenjualan() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'bagian_penjualan') {
            $this->redirect('auth/login');
        }
    }

    // ===========================
    // DASHBOARD
    // ===========================
    public function dashboard() {
        $this->requirePenjualan();

        $db = getDB();

        $totalPenyewaan     = $db->query("SELECT COUNT(*) as c FROM penyewaan")->fetch()['c'];
        $sewaBerlangsung    = $db->query("SELECT COUNT(*) as c FROM penyewaan WHERE status_penyewaan='aktif'")->fetch()['c'];
        $menungguKonfirmasi = $db->query("SELECT COUNT(*) as c FROM pembayaran WHERE status_bayar='menunggu'")->fetch()['c'];
        $pengembalianHariIni = $db->query(
            "SELECT COUNT(*) as c FROM penyewaan WHERE tanggal_kembali = CURDATE() AND status_penyewaan='aktif'"
        )->fetch()['c'];

        // Pendapatan bulan ini
        $pendapatanBulanIni = $db->query(
            "SELECT COALESCE(SUM(total_bayar),0) as c FROM pembayaran
             WHERE status_bayar='lunas' AND MONTH(tanggal_bayar)=MONTH(NOW()) AND YEAR(tanggal_bayar)=YEAR(NOW())"
        )->fetch()['c'];

        // Penyewaan menunggu diproses
        $sewaMenunggu = $db->query(
            "SELECT p.*, pl.nama_pelanggan FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.status_penyewaan = 'menunggu'
             ORDER BY p.created_at ASC LIMIT 8"
        )->fetchAll();

        // Pembayaran menunggu konfirmasi
        $bayarMenunggu = $db->query(
            "SELECT pb.*, p.kode_penyewaan, pl.nama_pelanggan
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE pb.status_bayar = 'menunggu'
             ORDER BY pb.created_at ASC LIMIT 5"
        )->fetchAll();

        // Alat yang harus dikembalikan hari ini
        $kembaliHariIni = $db->query(
            "SELECT p.*, pl.nama_pelanggan, pl.no_hp,
                    DATEDIFF(CURDATE(), p.tanggal_kembali) as hari_terlambat
             FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.tanggal_kembali <= CURDATE() AND p.status_penyewaan = 'aktif'
             ORDER BY p.tanggal_kembali ASC LIMIT 5"
        )->fetchAll();

        $this->renderPenjualan('penjualan/dashboard', [
            'pageTitle'           => 'Dashboard',
            'totalPenyewaan'      => $totalPenyewaan,
            'sewaBerlangsung'     => $sewaBerlangsung,
            'menungguKonfirmasi'  => $menungguKonfirmasi,
            'pengembalianHariIni' => $pengembalianHariIni,
            'pendapatanBulanIni'  => $pendapatanBulanIni,
            'sewaMenunggu'        => $sewaMenunggu,
            'bayarMenunggu'       => $bayarMenunggu,
            'kembaliHariIni'      => $kembaliHariIni,
        ]);
    }

    // ===========================
    // PENYEWAAN — INDEX
    // ===========================
    public function penyewaan() {
        $this->requirePenjualan();

        $status  = $_GET['status'] ?? '';
        $keyword = trim($_GET['keyword'] ?? '');
        $db = getDB();

        $sql = "SELECT p.*, pl.nama_pelanggan, pl.no_hp
                FROM penyewaan p
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $sql .= " AND p.status_penyewaan = ?";
            $params[] = $status;
        }
        if (!empty($keyword)) {
            $sql .= " AND (p.kode_penyewaan LIKE ? OR pl.nama_pelanggan LIKE ?)";
            $params[] = '%'.$keyword.'%';
            $params[] = '%'.$keyword.'%';
        }
        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $daftarSewa = $stmt->fetchAll();

        $this->renderPenjualan('penjualan/penyewaan/index', [
            'pageTitle'  => 'Kelola Penyewaan',
            'daftarSewa' => $daftarSewa,
            'status'     => $status,
            'keyword'    => $keyword,
        ]);
    }

    // PENYEWAAN — DETAIL
    public function penyewaanDetail($id) {
        $this->requirePenjualan();

        $db = getDB();
        $stmt = $db->prepare(
            "SELECT p.*, pl.nama_pelanggan, pl.email, pl.no_hp, pl.alamat
             FROM penyewaan p
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE p.id_penyewaan = ?"
        );
        $stmt->execute([$id]);
        $sewa = $stmt->fetch();

        if (!$sewa) {
            $this->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect('penjualan/penyewaan');
            return;
        }

        $detail       = (new DetailPenyewaan())->getByPenyewaan($id);
        $pembayaran   = (new Pembayaran())->getByPenyewaan($id);
        $pengembalian = (new Pengembalian())->getByPenyewaan($id);

        $this->renderPenjualan('penjualan/penyewaan/detail', [
            'pageTitle'    => 'Detail Penyewaan',
            'sewa'         => $sewa,
            'detail'       => $detail,
            'pembayaran'   => $pembayaran,
            'pengembalian' => $pengembalian,
        ]);
    }

    // PENYEWAAN — UPDATE STATUS
    public function penyewaanStatus($id) {
        $this->requirePenjualan();

        $status  = $this->post('status');
        $allowed = ['menunggu', 'diproses', 'aktif', 'selesai', 'dibatalkan'];

        if (in_array($status, $allowed)) {
            (new Penyewaan())->updateStatus($id, $status);
            $this->setFlash('success', 'Status penyewaan berhasil diupdate.');
        }
        $this->redirect('penjualan/penyewaanDetail/' . $id);
    }

    // ===========================
    // PEMBAYARAN — INDEX
    // ===========================
    public function pembayaran() {
        $this->requirePenjualan();

        $status = $_GET['status'] ?? '';
        $db = getDB();

        $sql = "SELECT pb.*, p.kode_penyewaan, p.total_harga,
                       pl.nama_pelanggan, pl.no_hp
                FROM pembayaran pb
                JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan";
        $params = [];

        if (!empty($status)) {
            $sql .= " WHERE pb.status_bayar = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY pb.created_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $daftarBayar = $stmt->fetchAll();

        $this->renderPenjualan('penjualan/pembayaran/index', [
            'pageTitle'   => 'Kelola Pembayaran',
            'daftarBayar' => $daftarBayar,
            'status'      => $status,
        ]);
    }

    // PEMBAYARAN — DETAIL & LIHAT BUKTI
    public function pembayaranDetail($id) {
        $this->requirePenjualan();

        $db = getDB();
        $stmt = $db->prepare(
            "SELECT pb.*, p.kode_penyewaan, p.tanggal_sewa, p.tanggal_kembali,
                    p.lama_sewa, p.total_harga, p.lokasi_pengiriman,
                    pl.nama_pelanggan, pl.email, pl.no_hp
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE pb.id_pembayaran = ?"
        );
        $stmt->execute([$id]);
        $pembayaran = $stmt->fetch();

        if (!$pembayaran) {
            $this->setFlash('error', 'Data tidak ditemukan.');
            $this->redirect('penjualan/pembayaran');
            return;
        }

        $detail = (new DetailPenyewaan())->getByPenyewaan($pembayaran['id_penyewaan']);

        $this->renderPenjualan('penjualan/pembayaran/detail', [
            'pageTitle'  => 'Detail Pembayaran',
            'pembayaran' => $pembayaran,
            'detail'     => $detail,
        ]);
    }

    // PEMBAYARAN — KONFIRMASI
    public function pembayaranKonfirmasi($id) {
        $this->requirePenjualan();

        $pembayaranModel = new Pembayaran();
        $bayar = $pembayaranModel->queryOne(
            "SELECT * FROM pembayaran WHERE id_pembayaran = ?", [$id]
        );

        if (!$bayar) {
            $this->redirect('penjualan/pembayaran');
            return;
        }

        $pembayaranModel->konfirmasi($id);

        // Pembayaran denda tidak mengubah status penyewaan (penyewaan sudah selesai)
        if (str_starts_with($bayar['kode_transaksi'], 'DND-')) {
            $this->setFlash('success', 'Pembayaran denda dikonfirmasi.');
        } else {
            (new Penyewaan())->updateStatus($bayar['id_penyewaan'], 'aktif');
            $this->setFlash('success', 'Pembayaran dikonfirmasi. Status penyewaan menjadi Aktif.');
        }
        $this->redirect('penjualan/pembayaran');
    }

    // PEMBAYARAN — TOLAK
    public function pembayaranTolak($id) {
        $this->requirePenjualan();

        $pembayaranModel = new Pembayaran();
        $bayar = $pembayaranModel->queryOne(
            "SELECT * FROM pembayaran WHERE id_pembayaran = ?", [$id]
        );

        if (!$bayar) {
            $this->redirect('penjualan/pembayaran');
            return;
        }

        $pembayaranModel->update($id, ['status_bayar' => 'gagal'], 'id_pembayaran');

        // Pembayaran denda tidak mengubah status penyewaan (penyewaan sudah selesai)
        if (str_starts_with($bayar['kode_transaksi'], 'DND-')) {
            $this->setFlash('error', 'Pembayaran denda ditolak.');
        } else {
            (new Penyewaan())->updateStatus($bayar['id_penyewaan'], 'dibatalkan');
            $this->setFlash('error', 'Pembayaran ditolak. Penyewaan dibatalkan.');
        }
        $this->redirect('penjualan/pembayaran');
    }

    // ===========================
    // PENGEMBALIAN — INDEX
    // ===========================
    public function pengembalian() {
        $this->requirePenjualan();

        $db = getDB();
        $daftarKembali = $db->query(
            "SELECT pg.*, p.kode_penyewaan, p.tanggal_kembali, p.total_harga, p.lama_sewa,
                    pl.nama_pelanggan, pl.no_hp
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

        $this->renderPenjualan('penjualan/pengembalian/index', [
            'pageTitle'    => 'Kelola Pengembalian',
            'daftarKembali' => $daftarKembali,
            'belumKembali'  => $belumKembali,
        ]);
    }

    // PENGEMBALIAN — PROSES (oleh staff)
    public function pengembalianProses($id_penyewaan) {
        $this->requirePenjualan();

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
            $this->redirect('penjualan/pengembalian');
            return;
        }

        // Cek sudah dikembalikan
        if ((new Pengembalian())->sudahDikembalikan($id_penyewaan)) {
            $this->setFlash('error', 'Alat sudah dikembalikan sebelumnya.');
            $this->redirect('penjualan/pengembalian');
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
            $this->redirect('penjualan/pengembalian');
            return;
        }

        $detail        = (new DetailPenyewaan())->getByPenyewaan($id_penyewaan);
        $today         = date('Y-m-d');
        $estimasiDenda = Pengembalian::hitungDenda($sewa['tanggal_kembali'], $today, $sewa['total_harga']);
        $statusEstimasi = Pengembalian::tentukanStatus($sewa['tanggal_kembali'], $today);

        $this->renderPenjualan('penjualan/pengembalian/proses', [
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
        $this->requirePenjualan();

        $dari   = $_GET['dari']   ?? date('Y-m-01');
        $sampai = $_GET['sampai'] ?? date('Y-m-t');
        $db     = getDB();

        $pendapatan = $db->prepare(
            "SELECT COALESCE(SUM(total_bayar),0) as total FROM pembayaran
             WHERE status_bayar='lunas' AND DATE(tanggal_bayar) BETWEEN ? AND ?"
        );
        $pendapatan->execute([$dari, $sampai]);
        $totalPendapatan = $pendapatan->fetch()['total'];

        $totalSewa = $db->prepare(
            "SELECT COUNT(*) as total FROM penyewaan WHERE DATE(created_at) BETWEEN ? AND ?"
        );
        $totalSewa->execute([$dari, $sampai]);
        $totalPenyewaan = $totalSewa->fetch()['total'];

        $denda = $db->prepare(
            "SELECT COALESCE(SUM(denda),0) as total FROM pengembalian
             WHERE DATE(created_at) BETWEEN ? AND ?"
        );
        $denda->execute([$dari, $sampai]);
        $totalDenda = $denda->fetch()['total'];

        $transaksi = $db->prepare(
            "SELECT pb.*, p.kode_penyewaan, pl.nama_pelanggan
             FROM pembayaran pb
             JOIN penyewaan p ON pb.id_penyewaan = p.id_penyewaan
             JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
             WHERE DATE(pb.created_at) BETWEEN ? AND ?
             ORDER BY pb.created_at DESC"
        );
        $transaksi->execute([$dari, $sampai]);
        $daftarTransaksi = $transaksi->fetchAll();

        if (isset($_GET['export'])) {
            $html = $this->buildLaporanHTML($dari, $sampai, $totalPendapatan, $totalPenyewaan, $totalDenda, $daftarTransaksi);
            $this->generatePDF($html, 'Laporan-Penjualan-' . $dari . '_sd_' . $sampai . '.pdf');
            return;
        }

        $this->renderPenjualan('penjualan/laporan/index', [
            'pageTitle'       => 'Laporan',
            'dari'            => $dari,
            'sampai'          => $sampai,
            'totalPendapatan' => $totalPendapatan,
            'totalPenyewaan'  => $totalPenyewaan,
            'totalDenda'      => $totalDenda,
            'daftarTransaksi' => $daftarTransaksi,
        ]);
    }

    // Susun HTML laporan untuk dijadikan PDF
    private function buildLaporanHTML($dari, $sampai, $totalPendapatan, $totalPenyewaan, $totalDenda, $daftarTransaksi) {
        $periode = date('d M Y', strtotime($dari)) . ' &ndash; ' . date('d M Y', strtotime($sampai));

        $rowsTransaksi = '';
        if (empty($daftarTransaksi)) {
            $rowsTransaksi = '<tr><td colspan="8" style="text-align:center;color:#888;">Tidak ada transaksi pada periode ini</td></tr>';
        } else {
            foreach ($daftarTransaksi as $i => $t) {
                $rowsTransaksi .= '<tr>
                    <td class="text-center">' . ($i + 1) . '</td>
                    <td>' . htmlspecialchars($t['kode_transaksi']) . '</td>
                    <td>' . htmlspecialchars($t['kode_penyewaan']) . '</td>
                    <td>' . htmlspecialchars($t['nama_pelanggan']) . '</td>
                    <td>' . ucfirst(str_replace('_', ' ', $t['metode_bayar'])) . '</td>
                    <td class="text-right">Rp ' . number_format($t['total_bayar'], 0, ',', '.') . '</td>
                    <td class="text-center">' . ucfirst($t['status_bayar']) . '</td>
                    <td>' . ($t['tanggal_bayar'] ? date('d M Y', strtotime($t['tanggal_bayar'])) : '-') . '</td>
                </tr>';
            }
        }

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
        </style></head><body>
            <div class="header">
                <img src="' . BASE_PATH . '/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
                <div class="brand">CV. HK SATU TUJUH</div>
                <div class="title">Laporan Transaksi - Bagian Penjualan</div>
            </div>
            <table class="meta">
                <tr>
                    <td>Periode: <b>' . $periode . '</b></td>
                    <td class="text-right">Dicetak: ' . date('d M Y H:i') . '</td>
                </tr>
            </table>

            <table class="summary">
                <tr>
                    <td class="card card-green"><span class="label">Total Pendapatan</span> = <span class="value">Rp ' . number_format($totalPendapatan, 0, ',', '.') . '</span></td>
                    <td class="card card-blue"><span class="label">Total Penyewaan</span> = <span class="value">' . $totalPenyewaan . '</span></td>
                    <td class="card card-red"><span class="label">Total Denda</span> = <span class="value">Rp ' . number_format($totalDenda, 0, ',', '.') . '</span></td>
                </tr>
            </table>

            <div class="section-title">Daftar Transaksi</div>
            <table>
                <thead><tr><th style="width:5%;">#</th><th>Kode Transaksi</th><th>Kode Sewa</th><th>Pelanggan</th><th>Metode</th><th class="text-right">Total</th><th class="text-center">Status</th><th>Tgl Bayar</th></tr></thead>
                <tbody>' . $rowsTransaksi . '</tbody>
            </table>
        </body></html>';
    }

    // ===========================
    // HELPER RENDER
    // ===========================
    private function renderPenjualan($view, $data = []) {
        if (!empty($data)) extract($data);
        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';
        if (!file_exists($viewPath)) die("View tidak ditemukan: $view");

        include BASE_PATH . '/app/views/admin/layouts/header.php';
        include $viewPath;
        include BASE_PATH . '/app/views/admin/layouts/footer.php';
    }
}
