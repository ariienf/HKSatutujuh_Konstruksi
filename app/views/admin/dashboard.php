<?php
/** @var int $totalAlat @var int $totalPelanggan @var int $totalPenyewaan
 *  @var float $totalPendapatan @var int $menungguKonfirmasi @var int $sewaBerlangsung
 *  @var array $grafikData @var array $sewaTerbaru @var array $bayarMenunggu */
$panelBase = match($_SESSION['user_role']) {
    'administrator' => BASE_URL . '/admin',
    'pimpinan'      => BASE_URL . '/pimpinan',
    default         => BASE_URL . '/admin',
};
?>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
  <?php
  // Format Rupiah ringkas (Jt/M) supaya muat di kartu statistik yang sempit
  $formatRupiahSingkat = function($angka) {
      if ($angka >= 1000000000) return 'Rp ' . rtrim(rtrim(number_format($angka / 1000000000, 1, ',', '.'), '0'), ',') . ' M';
      if ($angka >= 1000000)    return 'Rp ' . rtrim(rtrim(number_format($angka / 1000000, 1, ',', '.'), '0'), ',') . ' Jt';
      return 'Rp ' . number_format($angka, 0, ',', '.');
  };

  $stats = [
    ['label'=>'Total Alat',        'value'=> $totalAlat,       'icon'=>'tools',          'color'=>'#E05A1E', 'bg'=>'rgba(224,90,30,0.1)'],
    ['label'=>'Total Pelanggan',   'value'=> $totalPelanggan,  'icon'=>'people',         'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,0.1)'],
    ['label'=>'Total Penyewaan',   'value'=> $totalPenyewaan,  'icon'=>'file-text',      'color'=>'#8b5cf6', 'bg'=>'rgba(139,92,246,0.1)'],
    ['label'=>'Pendapatan',        'value'=> $formatRupiahSingkat($totalPendapatan), 'title'=>'Rp '.number_format($totalPendapatan,0,',','.'), 'icon'=>'cash-coin', 'color'=>'#22c55e', 'bg'=>'rgba(34,197,94,0.1)'],
    ['label'=>'Sewa Berlangsung',  'value'=> $sewaBerlangsung, 'icon'=>'clock',          'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)'],
    ['label'=>'Menunggu Konfirmasi','value'=> $menungguKonfirmasi,'icon'=>'exclamation-circle','color'=>'#ef4444','bg'=>'rgba(239,68,68,0.1)'],
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

<div class="row g-3 mb-4">
  <!-- GRAFIK PENDAPATAN -->
  <div class="col-lg-8">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-bar-chart-line me-2" style="color:var(--orange);"></i>Pendapatan 1 Bulan Terakhir</div>
      </div>
      <div class="content-card-body">
        <canvas id="grafikPendapatan" height="90"></canvas>
      </div>
    </div>
  </div>

  <!-- MENUNGGU KONFIRMASI -->
  <div class="col-lg-4">
    <div class="content-card" style="height:100%;">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-clock me-2" style="color:#f59e0b;"></i>Menunggu Konfirmasi</div>
        <a href="<?= $panelBase ?>/pembayaran?status=menunggu" class="btn-admin-secondary" style="font-size:0.75rem;padding:0.3rem 0.7rem;">Lihat Semua</a>
      </div>
      <div style="padding:0.5rem 0;">
        <?php if (empty($bayarMenunggu)): ?>
          <div style="text-align:center;padding:2rem;color:var(--muted);font-size:0.85rem;">
            <i class="bi bi-check-circle" style="font-size:2rem;color:#22c55e;display:block;margin-bottom:0.5rem;"></i>
            Semua pembayaran sudah dikonfirmasi
          </div>
        <?php else: ?>
          <?php foreach ($bayarMenunggu as $b): ?>
          <div style="padding:0.7rem 1.4rem;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <div>
              <div style="font-weight:600;font-size:0.83rem;"><?= htmlspecialchars($b['nama_pelanggan']) ?></div>
              <div style="font-size:0.75rem;color:var(--muted);"><?= htmlspecialchars($b['kode_penyewaan']) ?></div>
            </div>
            <div style="text-align:right;">
              <div style="font-weight:700;font-size:0.83rem;color:var(--orange);">Rp <?= number_format($b['total_bayar'],0,',','.') ?></div>
              <a href="<?= $panelBase ?>/pembayaranKonfirmasi/<?= $b['id_pembayaran'] ?>"
                 style="font-size:0.72rem;color:#22c55e;text-decoration:none;font-weight:600;"
                 onclick="return confirm('Konfirmasi pembayaran ini?')">
                ✓ Konfirmasi
              </a>
            </div>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- PENYEWAAN TERBARU -->
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-file-text me-2" style="color:var(--orange);"></i>Penyewaan Terbaru</div>
    <a href="<?= $panelBase ?>/penyewaan" class="btn-admin-secondary" style="font-size:0.75rem;padding:0.3rem 0.7rem;">Lihat Semua</a>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr>
          <th>Kode</th><th>Pelanggan</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($sewaTerbaru)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:2rem;">Belum ada data penyewaan</td></tr>
        <?php else: ?>
        <?php foreach ($sewaTerbaru as $s): ?>
        <tr>
          <td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($s['kode_penyewaan']) ?></span></td>
          <td><?= htmlspecialchars($s['nama_pelanggan']) ?></td>
          <td><?= date('d M Y', strtotime($s['tanggal_sewa'])) ?></td>
          <td><?= date('d M Y', strtotime($s['tanggal_kembali'])) ?></td>
          <td style="font-weight:700;">Rp <?= number_format($s['total_harga'],0,',','.') ?></td>
          <td><span class="badge-status badge-<?= $s['status_penyewaan'] ?>"><?= ucfirst($s['status_penyewaan']) ?></span></td>
          <td>
            <a href="<?= $panelBase ?>/penyewaanDetail/<?= $s['id_penyewaan'] ?>" class="btn-sm-icon" style="background:#f3f4f6;color:var(--steel);" title="Detail">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php ob_start(); ?>
<script>
const ctx = document.getElementById('grafikPendapatan').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?= implode(',', array_map(fn($d) => '"'.$d['tanggal'].'"', $grafikData)) ?>],
    datasets: [{
      label: 'Pendapatan (Rp)',
      data: [<?= implode(',', array_map(fn($d) => $d['total'], $grafikData)) ?>],
      backgroundColor: 'rgba(224,90,30,0.8)',
      borderRadius: 6,
      minBarLength: 3,
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
    }
  }
});
</script>
<?php $extraScript = ob_get_clean(); ?>