<?php
/** @var int $totalPenyewaan @var int $sewaBerlangsung @var int $menungguKonfirmasi
 *  @var int $pengembalianHariIni @var float $pendapatanBulanIni
 *  @var array $sewaMenunggu @var array $bayarMenunggu @var array $kembaliHariIni */
$panelBase = BASE_URL . '/penjualan';
?>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
  <?php
  // Format Rupiah ringkas (Jt/M) supaya muat di kartu statistik
  $formatRupiahSingkat = function($angka) {
      if ($angka >= 1000000000) return 'Rp ' . rtrim(rtrim(number_format($angka / 1000000000, 1, ',', '.'), '0'), ',') . ' M';
      if ($angka >= 1000000)    return 'Rp ' . rtrim(rtrim(number_format($angka / 1000000, 1, ',', '.'), '0'), ',') . ' Jt';
      return 'Rp ' . number_format($angka, 0, ',', '.');
  };

  $stats = [
    ['label'=>'Total Penyewaan',      'value'=> $totalPenyewaan,      'icon'=>'file-text',       'color'=>'#E05A1E', 'bg'=>'rgba(224,90,30,0.1)'],
    ['label'=>'Sewa Berlangsung',     'value'=> $sewaBerlangsung,     'icon'=>'clock',            'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,0.1)'],
    ['label'=>'Menunggu Konfirmasi',  'value'=> $menungguKonfirmasi,  'icon'=>'exclamation-circle','color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)'],
    ['label'=>'Harus Kembali Hari Ini','value'=> $pengembalianHariIni,'icon'=>'box-arrow-in-left','color'=>'#ef4444', 'bg'=>'rgba(239,68,68,0.1)'],
    ['label'=>'Pendapatan Bulan Ini', 'value'=> $formatRupiahSingkat($pendapatanBulanIni), 'title'=>'Rp '.number_format($pendapatanBulanIni,0,',','.'), 'icon'=>'cash-coin','color'=>'#22c55e','bg'=>'rgba(34,197,94,0.1)'],
  ];
  foreach ($stats as $s):
  ?>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon" style="background:<?= $s['bg'] ?>;">
        <i class="bi bi-<?= $s['icon'] ?>" style="color:<?= $s['color'] ?>;"></i>
      </div>
      <div class="stat-num" style="color:<?= $s['color'] ?>;" title="<?= htmlspecialchars($s['title'] ?? '') ?>"><?= $s['value'] ?></div>
      <div class="stat-label"><?= $s['label'] ?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="row g-3 mb-3">
  <!-- PENYEWAAN MENUNGGU DIPROSES -->
  <div class="col-lg-6">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title">
          <i class="bi bi-clock me-2" style="color:#f59e0b;"></i>Menunggu Diproses
        </div>
        <a href="<?= $panelBase ?>/penyewaan?status=menunggu" class="btn-admin-secondary" style="font-size:0.75rem;padding:0.3rem 0.7rem;">Lihat Semua</a>
      </div>
      <?php if (empty($sewaMenunggu)): ?>
        <div style="text-align:center;padding:2rem;color:var(--muted);font-size:0.85rem;">
          <i class="bi bi-check-circle" style="font-size:2rem;color:#22c55e;display:block;margin-bottom:0.5rem;"></i>
          Tidak ada penyewaan menunggu
        </div>
      <?php else: ?>
        <?php foreach ($sewaMenunggu as $s): ?>
        <div style="padding:0.8rem 1.4rem;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
          <div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.83rem;"><?= htmlspecialchars($s['kode_penyewaan']) ?></div>
            <div style="font-size:0.78rem;color:var(--muted);"><?= htmlspecialchars($s['nama_pelanggan']) ?> · <?= date('d M Y', strtotime($s['tanggal_sewa'])) ?></div>
          </div>
          <div style="text-align:right;">
            <div style="font-weight:700;font-size:0.83rem;color:var(--orange);">Rp <?= number_format($s['total_harga'],0,',','.') ?></div>
            <a href="<?= $panelBase ?>/penyewaanDetail/<?= $s['id_penyewaan'] ?>"
               style="font-size:0.72rem;color:#3b82f6;text-decoration:none;font-weight:600;">
              Proses →
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- PEMBAYARAN MENUNGGU KONFIRMASI -->
  <div class="col-lg-6">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title">
          <i class="bi bi-credit-card me-2" style="color:#22c55e;"></i>Menunggu Konfirmasi Bayar
        </div>
        <a href="<?= $panelBase ?>/pembayaran?status=menunggu" class="btn-admin-secondary" style="font-size:0.75rem;padding:0.3rem 0.7rem;">Lihat Semua</a>
      </div>
      <?php if (empty($bayarMenunggu)): ?>
        <div style="text-align:center;padding:2rem;color:var(--muted);font-size:0.85rem;">
          <i class="bi bi-check-circle" style="font-size:2rem;color:#22c55e;display:block;margin-bottom:0.5rem;"></i>
          Semua pembayaran sudah dikonfirmasi
        </div>
      <?php else: ?>
        <?php foreach ($bayarMenunggu as $b): ?>
        <div style="padding:0.8rem 1.4rem;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
          <div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.83rem;"><?= htmlspecialchars($b['kode_penyewaan']) ?></div>
            <div style="font-size:0.78rem;color:var(--muted);"><?= htmlspecialchars($b['nama_pelanggan']) ?> · <?= ucfirst(str_replace('_',' ',$b['metode_bayar'])) ?></div>
          </div>
          <div style="text-align:right;">
            <div style="font-weight:700;font-size:0.83rem;color:var(--orange);">Rp <?= number_format($b['total_bayar'],0,',','.') ?></div>
            <a href="<?= $panelBase ?>/pembayaranDetail/<?= $b['id_pembayaran'] ?>"
               style="font-size:0.72rem;color:#22c55e;text-decoration:none;font-weight:600;">
              Cek Bukti →
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- HARUS DIKEMBALIKAN -->
<?php if (!empty($kembaliHariIni)): ?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title">
      <i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>
      Alat Harus Dikembalikan Hari Ini / Terlambat
    </div>
    <a href="<?= $panelBase ?>/pengembalian" class="btn-admin-secondary" style="font-size:0.75rem;padding:0.3rem 0.7rem;">Lihat Semua</a>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode Sewa</th><th>Pelanggan</th><th>No. HP</th><th>Jadwal Kembali</th><th>Keterlambatan</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($kembaliHariIni as $k): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($k['kode_penyewaan']) ?></td>
          <td><?= htmlspecialchars($k['nama_pelanggan']) ?></td>
          <td><?= htmlspecialchars($k['no_hp']) ?></td>
          <td><?= date('d M Y', strtotime($k['tanggal_kembali'])) ?></td>
          <td>
            <?php if ($k['hari_terlambat'] > 0): ?>
              <span style="background:#fee2e2;color:#991b1b;font-size:0.75rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;">
                <?= $k['hari_terlambat'] ?> hari terlambat
              </span>
            <?php else: ?>
              <span style="background:#fef3c7;color:#92400e;font-size:0.75rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;">
                Hari ini
              </span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?= $panelBase ?>/pengembalianProses/<?= $k['id_penyewaan'] ?>"
               class="btn-admin-primary" style="font-size:0.78rem;padding:0.3rem 0.8rem;">
              <i class="bi bi-box-arrow-in-left"></i> Proses
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
