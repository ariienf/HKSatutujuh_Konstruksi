<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
$statusList = ['','menunggu','diproses','aktif','selesai','dibatalkan'];
?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-file-text me-2" style="color:var(--orange);"></i>Data Penyewaan</div>
    <div class="d-flex gap-2 flex-wrap">
      <?php foreach ($statusList as $s): ?>
      <a href="<?= $panelBase ?>/Penyewaan<?= $s ? '?status='.$s : '' ?>"
         style="font-size:0.78rem;padding:0.3rem 0.7rem;border-radius:6px;text-decoration:none;font-weight:600;
                background:<?= $status===$s ? 'var(--orange)' : '#f3f4f6' ?>;
                color:<?= $status===$s ? '#fff' : 'var(--steel)' ?>;">
        <?= $s ? ucfirst($s) : 'Semua' ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode</th><th>Pelanggan</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Lama</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarSewa)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:2rem;">Tidak ada data</td></tr>
        <?php else: ?>
        <?php foreach ($daftarSewa as $s): ?>
        <tr>
          <td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($s['kode_penyewaan']) ?></span></td>
          <td><?= htmlspecialchars($s['nama_pelanggan']) ?></td>
          <td><?= date('d M Y', strtotime($s['tanggal_sewa'])) ?></td>
          <td><?= date('d M Y', strtotime($s['tanggal_kembali'])) ?></td>
          <td><?= $s['lama_sewa'] ?> hari</td>
          <td style="font-weight:700;">Rp <?= number_format($s['total_harga'],0,',','.') ?></td>
          <td><span class="badge-status badge-<?= $s['status_penyewaan'] ?>"><?= ucfirst($s['status_penyewaan']) ?></span></td>
          <td>
            <a href="<?= $panelBase ?>/PenyewaanDetail/<?= $s['id_penyewaan'] ?>" class="btn-sm-icon" style="background:#f3f4f6;color:var(--steel);" title="Detail"><i class="bi bi-eye"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>