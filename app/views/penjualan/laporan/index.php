<?php
$panelBase    = BASE_URL . '/penjualan';
$todayStr     = date('Y-m-d');
$mingguAwal   = date('Y-m-d', strtotime('monday this week'));
$mingguAkhir  = date('Y-m-d', strtotime('sunday this week'));
$bulanAwal    = date('Y-m-01');
$bulanAkhir   = date('Y-m-t');
$periodeLabel = date('d M Y', strtotime($dari)) . ' - ' . date('d M Y', strtotime($sampai));
?>

<!-- FILTER -->
<div class="content-card mb-4">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-bar-chart-line me-2" style="color:var(--orange);"></i>Laporan Transaksi</div>
  </div>
  <div class="content-card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <label style="font-size:0.82rem;font-weight:600;">Dari:</label>
      <input type="date" name="dari" value="<?= $dari ?>" class="form-control-admin" style="width:auto;display:inline-block;"/>
      <label style="font-size:0.82rem;font-weight:600;">Sampai:</label>
      <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control-admin" style="width:auto;display:inline-block;"/>
      <button type="submit" class="btn-admin-primary"><i class="bi bi-search"></i> Tampilkan</button>
      <a href="<?= $panelBase ?>/laporan?dari=<?= $dari ?>&sampai=<?= $sampai ?>&export=1" class="btn-admin-secondary">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
      </a>
    </form>
    <div style="display:flex;gap:8px;margin-top:0.7rem;flex-wrap:wrap;">
      <a href="<?= $panelBase ?>/laporan?dari=<?= $todayStr ?>&sampai=<?= $todayStr ?>" class="btn-admin-secondary" style="padding:0.3rem 0.7rem;font-size:0.75rem;">Hari Ini</a>
      <a href="<?= $panelBase ?>/laporan?dari=<?= $mingguAwal ?>&sampai=<?= $mingguAkhir ?>" class="btn-admin-secondary" style="padding:0.3rem 0.7rem;font-size:0.75rem;">Minggu Ini</a>
      <a href="<?= $panelBase ?>/laporan?dari=<?= $bulanAwal ?>&sampai=<?= $bulanAkhir ?>" class="btn-admin-secondary" style="padding:0.3rem 0.7rem;font-size:0.75rem;">Bulan Ini</a>
    </div>
  </div>
</div>

<!-- RINGKASAN -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(34,197,94,0.1);"><i class="bi bi-cash-coin" style="color:#22c55e;"></i></div>
      <div class="stat-num" style="color:#22c55e;font-size:1.4rem;">Rp <?= number_format($totalPendapatan,0,',','.') ?></div>
      <div class="stat-label">Total Pendapatan <?= $periodeLabel ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(59,130,246,0.1);"><i class="bi bi-file-text" style="color:#3b82f6;"></i></div>
      <div class="stat-num" style="color:#3b82f6;"><?= $totalPenyewaan ?></div>
      <div class="stat-label">Total Penyewaan <?= $periodeLabel ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon" style="background:rgba(239,68,68,0.1);"><i class="bi bi-exclamation-triangle" style="color:#ef4444;"></i></div>
      <div class="stat-num" style="color:#ef4444;font-size:1.4rem;">Rp <?= number_format($totalDenda,0,',','.') ?></div>
      <div class="stat-label">Total Denda <?= $periodeLabel ?></div>
    </div>
  </div>
</div>

<!-- DAFTAR TRANSAKSI -->
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-list-check me-2" style="color:var(--orange);"></i>Daftar Transaksi — <?= $periodeLabel ?></div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode Transaksi</th><th>Kode Sewa</th><th>Pelanggan</th><th>Metode</th><th>Total</th><th>Status</th><th>Tgl Bayar</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarTransaksi)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:2rem;">Tidak ada transaksi bulan ini</td></tr>
        <?php else: ?>
        <?php foreach ($daftarTransaksi as $t): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($t['kode_transaksi']) ?></td>
          <td style="font-size:0.82rem;"><?= htmlspecialchars($t['kode_penyewaan']) ?></td>
          <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
          <td><span style="font-size:0.75rem;background:#f3f4f6;padding:0.2rem 0.5rem;border-radius:4px;"><?= ucfirst(str_replace('_',' ',$t['metode_bayar'])) ?></span></td>
          <td style="font-weight:700;">Rp <?= number_format($t['total_bayar'],0,',','.') ?></td>
          <td><span class="badge-status badge-<?= $t['status_bayar'] ?>"><?= ucfirst($t['status_bayar']) ?></span></td>
          <td style="font-size:0.8rem;color:var(--muted);"><?= $t['tanggal_bayar'] ? date('d M Y', strtotime($t['tanggal_bayar'])) : '-' ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
