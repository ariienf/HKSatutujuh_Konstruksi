<?php

require_once BASE_PATH . '/app/models/Penyewaan.php';
require_once BASE_PATH . '/app/models/DetailPenyewaan.php';
require_once BASE_PATH . '/app/models/Pembayaran.php';
require_once BASE_PATH . '/app/models/Pelanggan.php';
require_once BASE_PATH . '/app/models/Pengembalian.php';

class SuratController extends Controller {

    // ===========================
    // DOWNLOAD SURAT KETERANGAN
    // ===========================
    public function download($id_penyewaan) {
        $this->requireLogin();

        $id_pelanggan = $_SESSION['pelanggan_id'];

        // Ambil data penyewaan milik pelanggan ini
        $penyewaanModel = new Penyewaan();
        $sewa = $penyewaanModel->getByIdAndPelanggan($id_penyewaan, $id_pelanggan);

        if (!$sewa) {
            $this->setFlash('error', 'Data penyewaan tidak ditemukan.');
            $this->redirect('Penyewaan/riwayat');
            return;
        }

        // Hanya bisa download jika pembayaran sudah lunas
        $pembayaranModel = new Pembayaran();
        $pembayaran = $pembayaranModel->getByPenyewaan($id_penyewaan);

        if (!$pembayaran || $pembayaran['status_bayar'] !== 'lunas') {
            $this->setFlash('error', 'Surat keterangan hanya tersedia setelah pembayaran dikonfirmasi.');
            $this->redirect('penyewaan/detail/' . $id_penyewaan);
            return;
        }

        // Blokir download selama denda belum lunas/terverifikasi
        if ($this->adaDendaBelumLunas($id_penyewaan)) {
            return;
        }

        // Ambil data pelanggan
        $pelanggan = (new Pelanggan())->getOneWhere('id_pelanggan', $id_pelanggan);

        // Ambil detail alat
        $detail = (new DetailPenyewaan())->getByPenyewaan($id_penyewaan);

        // Generate HTML untuk PDF
        $html = $this->buildSuratHTML($sewa, $pembayaran, $pelanggan, $detail);

        // Generate PDF menggunakan mPDF
        $this->generateSuratPDF($html, 'Surat-Keterangan-' . $sewa['kode_penyewaan'] . '.pdf');
    }

    // ===========================
    // HELPER
    // ===========================
    // Cek apakah penyewaan ini punya denda yang belum lunas/terverifikasi.
    // Kalau ya, set flash & redirect ke riwayat, lalu kembalikan true supaya caller berhenti.
    private function adaDendaBelumLunas($id_penyewaan) {
        $pengembalianModel = new Pengembalian();
        $pengembalian = $pengembalianModel->getByPenyewaan($id_penyewaan);

        if (!$pengembalian || $pengembalian['denda'] <= 0) {
            return false;
        }

        $pembayaranModel = new Pembayaran();
        $dendaBayar = $pembayaranModel->getDendaByPenyewaan($id_penyewaan);

        if (!$dendaBayar) {
            $this->setFlash('error', 'Anda memiliki denda keterlambatan yang belum dibayar. Silakan bayar denda terlebih dahulu untuk mengunduh surat keterangan.');
            $this->redirect('penyewaan/riwayat');
            return true;
        }

        if ($dendaBayar['status_bayar'] !== 'lunas') {
            $this->setFlash('error', 'Pembayaran denda Anda sedang menunggu konfirmasi admin. Surat keterangan akan tersedia setelah dikonfirmasi.');
            $this->redirect('penyewaan/riwayat');
            return true;
        }

        return false;
    }

    // ===========================
    // BUILD HTML SURAT
    // ===========================
    private function buildSuratHTML($sewa, $pembayaran, $pelanggan, $detail) {
        $nomorSurat = 'SKS/' . date('Y') . '/' . str_replace('SW-', '', $sewa['kode_penyewaan']);
        $tanggalCetak = date('d F Y');
        $bulanIndo = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        // Format tanggal Indonesia
        $tglSewa    = date('j', strtotime($sewa['tanggal_sewa'])) . ' ' . $bulanIndo[(int)date('n', strtotime($sewa['tanggal_sewa']))] . ' ' . date('Y', strtotime($sewa['tanggal_sewa']));
        $tglKembali = date('j', strtotime($sewa['tanggal_kembali'])) . ' ' . $bulanIndo[(int)date('n', strtotime($sewa['tanggal_kembali']))] . ' ' . date('Y', strtotime($sewa['tanggal_kembali']));
        $tglBayar   = date('j', strtotime($pembayaran['tanggal_bayar'])) . ' ' . $bulanIndo[(int)date('n', strtotime($pembayaran['tanggal_bayar']))] . ' ' . date('Y', strtotime($pembayaran['tanggal_bayar']));

        // Baris detail alat
        $rowsAlat = '';
        $no = 1;
        foreach ($detail as $d) {
            $rowsAlat .= '
            <tr>
                <td style="text-align:center;padding:6px 8px;border:1px solid #ddd;">' . $no++ . '</td>
                <td style="padding:6px 8px;border:1px solid #ddd;">' . htmlspecialchars($d['nama_alat']) . '</td>
                <td style="padding:6px 8px;border:1px solid #ddd;">' . htmlspecialchars($d['jenis_alat']) . '</td>
                <td style="text-align:center;padding:6px 8px;border:1px solid #ddd;">' . $d['jumlah'] . ' unit</td>
                <td style="text-align:right;padding:6px 8px;border:1px solid #ddd;">Rp ' . number_format($d['biaya_sewa'], 0, ',', '.') . '</td>
                <td style="text-align:right;padding:6px 8px;border:1px solid #ddd;">Rp ' . number_format($d['subtotal'], 0, ',', '.') . '</td>
            </tr>';
        }

        $html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 11pt;
    color: #1a1a1a;
    margin: 0;
    padding: 0;
  }
  .kop-wrap {
    border-bottom: 3px solid #E05A1E;
    padding-bottom: 12px;
    margin-bottom: 16px;
  }
  .kop {
    width: 100%;
    border-collapse: collapse;
  }
  .kop td {
    vertical-align: middle;
    padding: 0;
  }
  .kop-logo {
    width: 80px;
  }
  .kop-logo-box {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
  }
  .kop-info {
    padding-left: 12px;
  }
  .kop-nama {
    font-size: 16pt;
    font-weight: bold;
    color: #1A2332;
    margin: 0;
  }
  .kop-nama span { color: #E05A1E; }
  .kop-alamat {
    font-size: 9pt;
    color: #666;
    margin: 2px 0 0;
  }
  .judul-surat {
    text-align: center;
    margin: 16px 0 4px;
  }
  .judul-surat h2 {
    font-size: 14pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0;
    color: #1A2332;
  }
  .nomor-surat {
    text-align: center;
    font-size: 10pt;
    color: #666;
    margin-bottom: 16px;
  }
  .garis { border: none; border-top: 1px solid #ddd; margin: 12px 0; }
  .section-title {
    font-weight: bold;
    font-size: 10pt;
    color: #E05A1E;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 14px 0 6px;
    border-left: 3px solid #E05A1E;
    padding-left: 8px;
  }
  .info-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
  .info-table td { padding: 4px 6px; font-size: 10pt; vertical-align: top; }
  .info-table td:first-child { width: 160px; color: #555; }
  .info-table td:nth-child(2) { width: 10px; }
  .info-table td:last-child { font-weight: 600; }
  .alat-table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 10pt; }
  .alat-table thead tr { background: #cecece; color: #fff; }
  .alat-table thead td { padding: 7px 8px; border: 1px solid #1A2332; }
  .alat-table tbody tr:nth-child(even) { background: #f9f9f9; }
  .total-row { background: #fff3ee !important; }
  .total-row td { font-weight: bold; color: #E05A1E; }
  .status-lunas {
    display: inline-block;
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    border-radius: 4px;
    padding: 2px 10px;
    font-size: 9pt;
    font-weight: bold;
  }
  .catatan {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 9pt;
    color: #92400e;
    margin: 14px 0;
  }
  .ttd-section { margin-top: 24px; }
  .ttd-table { width: 100%; }
  .ttd-table td { text-align: center; padding: 8px; vertical-align: top; }
  .ttd-box { margin-top: 60px; border-top: 1px solid #333; padding-top: 4px; font-size: 10pt; font-weight: bold; }
  .footer-pdf {
    margin-top: 20px;
    border-top: 1px solid #ddd;
    padding-top: 8px;
    font-size: 8pt;
    color: #999;
    text-align: center;
  }

</style>
</head>
<body>

<!-- KOP SURAT -->
<div class="kop-wrap">
  <table class="kop">
    <tr>
      <td class="kop-logo">
        <img class="kop-logo-box" src="' . BASE_PATH . '/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
      </td>
      <td class="kop-info">
        <p class="kop-nama">CV. HK <span>SATU TUJUH</span></p>
        <p class="kop-alamat">
          Perumahan BKP Blok X, Jl. Baru I Kemiling Permai, Kec. Kemiling, Kota Bandar Lampung 35158
        </p>
          <p class="kop-alamat">
          Telp: 0822-5870-7017 &nbsp;|&nbsp;
          Email: hksatutujuh2024@gmail.com
        </p>
      </td>
    </tr>
  </table>
</div>

<!-- JUDUL -->
<div class="judul-surat">
  <h2>Surat Keterangan Penyewaan</h2>
</div>
<div class="nomor-surat">Nomor: ' . $nomorSurat . '</div>

<hr class="garis"/>

<!-- IDENTITAS PELANGGAN -->
<div class="section-title">Data Pelanggan</div>
<table class="info-table">
  <tr>
    <td>Nama Lengkap</td><td>:</td>
    <td>' . htmlspecialchars($pelanggan['nama_pelanggan']) . '</td>
  </tr>
  <tr>
    <td>Email</td><td>:</td>
    <td>' . htmlspecialchars($pelanggan['email']) . '</td>
  </tr>
  <tr>
    <td>No. HP / WA</td><td>:</td>
    <td>' . htmlspecialchars($pelanggan['no_hp']) . '</td>
  </tr>
  <tr>
    <td>Alamat</td><td>:</td>
    <td>' . htmlspecialchars($pelanggan['alamat'] ?? '-') . '</td>
  </tr>
  ' . (!empty($pelanggan['nama_perusahaan']) ? '
  <tr>
    <td>Perusahaan</td><td>:</td>
    <td>' . htmlspecialchars($pelanggan['nama_perusahaan']) . '</td>
  </tr>' : '') . '
</table>

<!-- DETAIL PENYEWAAN -->
<div class="section-title">Detail Penyewaan</div>
<table class="info-table">
  <tr>
    <td>Kode Penyewaan</td><td>:</td>
    <td><strong>' . htmlspecialchars($sewa['kode_penyewaan']) . '</strong></td>
  </tr>
  <tr>
    <td>Tanggal Mulai Sewa</td><td>:</td>
    <td>' . $tglSewa . '</td>
  </tr>
  <tr>
    <td>Tanggal Kembali</td><td>:</td>
    <td>' . $tglKembali . '</td>
  </tr>
  <tr>
    <td>Lama Sewa</td><td>:</td>
    <td>' . $sewa['lama_sewa'] . ' hari</td>
  </tr>
  <tr>
    <td>Lokasi Pengiriman</td><td>:</td>
    <td>' . htmlspecialchars($sewa['lokasi_pengiriman']) . '</td>
  </tr>
</table>

<!-- DAFTAR ALAT -->
<div class="section-title">Daftar Alat yang Disewa</div>
<table class="alat-table">
  <thead>
    <tr>
      <td style="text-align:center;width:30px;">No</td>
      <td>Nama Alat</td>
      <td>Jenis</td>
      <td style="text-align:center;">Jumlah</td>
      <td style="text-align:right;">Harga/Hari</td>
      <td style="text-align:right;">Subtotal</td>
    </tr>
  </thead>
  <tbody>
    ' . $rowsAlat . '
    <tr class="total-row">
      <td colspan="5" style="text-align:right;padding:7px 8px;border:1px solid #ddd;font-weight:bold;">
        TOTAL HARGA
      </td>
      <td style="text-align:right;padding:7px 8px;border:1px solid #ddd;font-weight:bold;color:#E05A1E;">
        Rp ' . number_format($sewa['total_harga'], 0, ',', '.') . '
      </td>
    </tr>
  </tbody>
</table>

<!-- INFO PEMBAYARAN -->
<div class="section-title">Informasi Pembayaran</div>
<table class="info-table">
  <tr>
    <td>Kode Transaksi</td><td>:</td>
    <td>' . htmlspecialchars($pembayaran['kode_transaksi']) . '</td>
  </tr>
  <tr>
    <td>Metode Pembayaran</td><td>:</td>
    <td>' . ucfirst(str_replace('_', ' ', $pembayaran['metode_bayar'])) . '</td>
  </tr>
  <tr>
    <td>Tanggal Pembayaran</td><td>:</td>
    <td>' . $tglBayar . '</td>
  </tr>
  <tr>
    <td>Total Dibayar</td><td>:</td>
    <td><strong>Rp ' . number_format($pembayaran['total_bayar'], 0, ',', '.') . '</strong></td>
  </tr>
  <tr>
    <td>Status</td><td>:</td>
    <td><span class="status-lunas">&#10003; LUNAS</span></td>
  </tr>
</table>

<!-- CATATAN -->
<div class="catatan">
  <strong>Catatan Penting:</strong><br/>
  1. Surat keterangan ini merupakan bukti sah penyewaan alat konstruksi.<br/>
  2. Alat wajib dikembalikan paling lambat tanggal <strong>' . $tglKembali . '</strong>.<br/>
  3. Keterlambatan pengembalian akan dikenakan denda sebesar 10% per hari dari total harga sewa.<br/>
  4. Kerusakan alat akibat kelalaian menjadi tanggung jawab penyewa.<br/>
  5. Simpan surat ini sebagai bukti penyewaan yang sah.
</div>

<!-- TANDA TANGAN -->
<div class="ttd-section">
  <table class="ttd-table">
    <tr>
      <td style="width:50%;">
        Bandar Lampung, ' . $tanggalCetak . '<br/>
        <strong>Penyewa</strong>
        <div class="ttd-box">( ' . htmlspecialchars($pelanggan['nama_pelanggan']) . ' )</div>
      </td>
      <td style="width:50%;">
        Bandar Lampung, ' . $tanggalCetak . '<br/>
        <strong>CV. HK SATU TUJUH</strong>
        <div class="ttd-box">( Bagian Penjualan )</div>
      </td>
    </tr>
  </table>
</div>

<!-- FOOTER -->
<div class="footer-pdf">
  Dokumen ini digenerate secara otomatis oleh sistem HK Satu Tujuh pada ' . date('d/m/Y H:i') . ' WIB.
  Dokumen ini sah tanpa tanda tangan basah jika memiliki kode verifikasi: <strong>' . strtoupper(substr(md5($sewa['kode_penyewaan']), 0, 12)) . '</strong>
</div>

</body>
</html>';

        return $html;
    }

    // ===========================
    // GENERATE PDF dengan mPDF
    // ===========================
    private function generateSuratPDF($html, $filename) {
        // Cek apakah mPDF sudah terinstall via Composer
        $autoload = BASE_PATH . '/vendor/autoload.php';

        if (!file_exists($autoload)) {
            // Fallback: tampilkan HTML saja jika mPDF belum diinstall
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

        $mpdf->SetTitle('Surat Keterangan Penyewaan');
        $mpdf->SetAuthor('HK Satu Tujuh');
        $mpdf->SetCreator('HK Satu Tujuh System');

        // Watermark "LUNAS" digambar di lapisan paling belakang (di bawah teks),
        // pakai fitur watermark bawaan mPDF supaya urutan lapisannya reliabel.
        $mpdf->SetWatermarkText(new \Mpdf\WatermarkText('LUNAS', 130, -30, '#22c55e', 0.12, 'Arial'));
        $mpdf->showWatermarkText = true;

        $mpdf->WriteHTML($html);

        // Download langsung ke browser
        $mpdf->Output($filename, 'D');
        exit;
    }
}
