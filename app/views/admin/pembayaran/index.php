<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-credit-card me-2" style="color:var(--orange);"></i>Data Pembayaran</div>
    <div class="d-flex gap-2">
      <?php foreach ([''=>'Semua','menunggu'=>'Menunggu','lunas'=>'Lunas','gagal'=>'Gagal'] as $val=>$lbl): ?>
      <a href="<?= $panelBase ?>/pembayaran<?= $val ? '?status='.$val : '' ?>"
         style="font-size:0.78rem;padding:0.3rem 0.7rem;border-radius:6px;text-decoration:none;font-weight:600;
                background:<?= $status===$val?'var(--orange)':'#f3f4f6' ?>;
                color:<?= $status===$val?'#fff':'var(--steel)' ?>;">
        <?= $lbl ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode Transaksi</th><th>Kode Sewa</th><th>Pelanggan</th><th>Metode</th><th>Total</th><th>Status</th><th>Tgl Bayar</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarBayar)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:2rem;">Tidak ada data</td></tr>
        <?php else: ?>
        <?php foreach ($daftarBayar as $b): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;">
            <?= htmlspecialchars($b['kode_transaksi']) ?>
            <?php if (str_starts_with($b['kode_transaksi'], 'DND-')): ?>
              <span style="background:#fee2e2;color:#991b1b;font-size:0.65rem;font-weight:700;padding:0.1rem 0.4rem;border-radius:4px;margin-left:0.3rem;">DENDA</span>
            <?php endif; ?>
          </td>
          <td style="font-size:0.82rem;"><?= htmlspecialchars($b['kode_penyewaan']) ?></td>
          <td><?= htmlspecialchars($b['nama_pelanggan']) ?></td>
          <td><span style="font-size:0.75rem;background:#f3f4f6;padding:0.2rem 0.5rem;border-radius:4px;"><?= ucfirst(str_replace('_',' ',$b['metode_bayar'])) ?></span></td>
          <td style="font-weight:700;">Rp <?= number_format($b['total_bayar'],0,',','.') ?></td>
          <td><span class="badge-status badge-<?= $b['status_bayar'] ?>"><?= ucfirst($b['status_bayar']) ?></span></td>
          <td style="font-size:0.8rem;color:var(--muted);"><?= $b['tanggal_bayar'] ? date('d M Y', strtotime($b['tanggal_bayar'])) : '-' ?></td>
          <td>
            <div class="d-flex gap-1">
              <?php if ($b['status_bayar'] === 'menunggu'): ?>
              <a href="<?= $panelBase ?>/pembayaranKonfirmasi/<?= $b['id_pembayaran'] ?>"
                 class="btn-sm-icon" style="background:#d1fae5;color:#065f46;" title="Konfirmasi"
                 onclick="return confirm('Konfirmasi pembayaran ini?')">
                <i class="bi bi-check-lg"></i>
              </a>
              <a href="<?= $panelBase ?>/pembayaranTolak/<?= $b['id_pembayaran'] ?>"
                 class="btn-sm-icon" style="background:#fee2e2;color:#991b1b;" title="Tolak"
                 onclick="return confirm('Tolak pembayaran ini?')">
                <i class="bi bi-x-lg"></i>
              </a>
              <?php endif; ?>
              <?php if (!empty($b['bukti_bayar'])): ?>
              <a href="<?= BASE_URL ?>/public/uploads/bukti/<?= htmlspecialchars($b['bukti_bayar']) ?>" target="_blank"
                 class="btn-sm-icon" style="background:#dbeafe;color:#1e40af;" title="Lihat Bukti">
                <i class="bi bi-image"></i>
              </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>