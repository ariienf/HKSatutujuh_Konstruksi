<?php
$panelBase    = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
$todayStr     = date('Y-m-d');
$mingguAwal   = date('Y-m-d', strtotime('monday this week'));
$mingguAkhir  = date('Y-m-d', strtotime('sunday this week'));
$bulanAwal    = date('Y-m-01');
$bulanAkhir   = date('Y-m-t');
$periodeLabel = date('d M Y', strtotime($dari)) . ' - ' . date('d M Y', strtotime($sampai));
?>
<!-- FILTER PERIODE -->
<div class="content-card mb-4">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-bar-chart-line me-2" style="color:var(--orange);"></i>Laporan Periode</div>
  </div>
  <div class="content-card-body">
    <form method="GET" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <div>
        <label style="font-size:0.82rem;font-weight:600;margin-right:0.5rem;">Dari:</label>
        <input type="date" name="dari" value="<?= $dari ?>" class="form-control-admin" style="width:auto;display:inline-block;"/>
      </div>
      <div>
        <label style="font-size:0.82rem;font-weight:600;margin-right:0.5rem;">Sampai:</label>
        <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control-admin" style="width:auto;display:inline-block;"/>
      </div>
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
      <div class="stat-num" style="color:#22c55e;">Rp <?= number_format($totalPendapatan,0,',','.') ?></div>
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
      <div class="stat-num" style="color:#ef4444;">Rp <?= number_format($totalDenda,0,',','.') ?></div>
      <div class="stat-label">Total Denda <?= $periodeLabel ?></div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <!-- ALAT TERPOPULER -->
  <div class="col-md-5">
    <div class="content-card">
      <div class="content-card-header"><div class="content-card-title"><i class="bi bi-trophy me-2" style="color:#f59e0b;"></i>Alat Terpopuler</div></div>
      <div style="padding:0.5rem 0;">
        <?php if (empty($alatTerpopuler)): ?>
          <div style="text-align:center;color:var(--muted);padding:1.5rem;font-size:0.83rem;">Tidak ada data</div>
        <?php else: ?>
        <?php foreach ($alatTerpopuler as $i => $a): ?>
        <div style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem 1.4rem;border-bottom:1px solid #f3f4f6;">
          <div style="width:26px;height:26px;border-radius:50%;background:<?= $i===0?'#f59e0b':($i===1?'#9ca3af':($i===2?'#92400e':'#f3f4f6')) ?>;
                      color:<?= $i<3?'#fff':'var(--steel)' ?>;display:flex;align-items:center;justify-content:center;
                      font-weight:800;font-size:0.78rem;flex-shrink:0;">
            <?= $i+1 ?>
          </div>
          <div style="flex:1;">
            <div style="font-weight:600;font-size:0.85rem;"><?= htmlspecialchars($a['nama_alat']) ?></div>
            <div style="font-size:0.75rem;color:var(--muted);"><?= htmlspecialchars($a['jenis_alat']) ?></div>
          </div>
          <div style="font-weight:800;font-size:0.9rem;color:var(--orange);"><?= $a['total_disewa'] ?>×</div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- DAFTAR TRANSAKSI -->
  <div class="col-md-7">
    <div class="content-card">
      <div class="content-card-header"><div class="content-card-title"><i class="bi bi-list-check me-2" style="color:var(--orange);"></i>Transaksi Periode Ini</div></div>
      <div style="overflow-x:auto;">
        <table class="table-admin table">
          <thead>
            <tr><th>Kode</th><th>Pelanggan</th><th>Metode</th><th>Total</th><th>Status</th></tr>
          </thead>
          <tbody>
            <?php if (empty($daftarTransaksi)): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:1.5rem;">Tidak ada transaksi</td></tr>
            <?php else: ?>
            <?php foreach ($daftarTransaksi as $t): ?>
            <tr>
              <td style="font-size:0.78rem;font-family:'Syne',sans-serif;font-weight:700;"><?= htmlspecialchars($t['kode_transaksi']) ?></td>
              <td style="font-size:0.83rem;"><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
              <td><span style="font-size:0.72rem;background:#f3f4f6;padding:0.2rem 0.4rem;border-radius:4px;"><?= ucfirst(str_replace('_',' ',$t['metode_bayar'])) ?></span></td>
              <td style="font-weight:700;font-size:0.83rem;">Rp <?= number_format($t['total_bayar'],0,',','.') ?></td>
              <td><span class="badge-status badge-<?= $t['status_bayar'] ?>"><?= ucfirst($t['status_bayar']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>