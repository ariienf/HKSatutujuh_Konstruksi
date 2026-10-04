<?php
$panelBase = BASE_URL . '/penjualan';
$statusList = [''=>'Semua','menunggu'=>'Menunggu','diproses'=>'Diproses','aktif'=>'Aktif','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-file-text me-2" style="color:var(--orange);"></i>Data Penyewaan</div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
      <!-- Filter status -->
      <div class="d-flex gap-1 flex-wrap">
        <?php foreach ($statusList as $val => $lbl): ?>
        <a href="<?= $panelBase ?>/penyewaan<?= $val ? '?status='.$val : '' ?>"
           style="font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:5px;text-decoration:none;font-weight:600;
                  background:<?= $status===$val?'var(--orange)':'#f3f4f6' ?>;
                  color:<?= $status===$val?'#fff':'var(--steel)' ?>;">
          <?= $lbl ?>
        </a>
        <?php endforeach; ?>
      </div>
      <!-- Search -->
      <form method="GET" style="display:flex;gap:5px;">
        <?php if ($status): ?><input type="hidden" name="status" value="<?= $status ?>"/><?php endif; ?>
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
               placeholder="Cari kode / pelanggan..." class="form-control-admin" style="width:190px;font-size:0.83rem;"/>
        <button type="submit" class="btn-admin-secondary" style="padding:0.4rem 0.7rem;"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode</th><th>Pelanggan</th><th>No. HP</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarSewa)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:2rem;">Tidak ada data</td></tr>
        <?php else: ?>
        <?php foreach ($daftarSewa as $s): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($s['kode_penyewaan']) ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($s['nama_pelanggan']) ?></td>
          <td style="font-size:0.82rem;"><?= htmlspecialchars($s['no_hp']) ?></td>
          <td style="font-size:0.82rem;"><?= date('d M Y', strtotime($s['tanggal_sewa'])) ?></td>
          <td style="font-size:0.82rem;<?= strtotime($s['tanggal_kembali']) < time() && $s['status_penyewaan']==='aktif' ? 'color:#ef4444;font-weight:700;' : '' ?>">
            <?= date('d M Y', strtotime($s['tanggal_kembali'])) ?>
          </td>
          <td style="font-weight:700;">Rp <?= number_format($s['total_harga'],0,',','.') ?></td>
          <td><span class="badge-status badge-<?= $s['status_penyewaan'] ?>"><?= ucfirst($s['status_penyewaan']) ?></span></td>
          <td>
            <div class="d-flex gap-1">
              <a href="<?= $panelBase ?>/PenyewaanDetail/<?= $s['id_penyewaan'] ?>"
                 class="btn-sm-icon" style="background:#f3f4f6;color:var(--steel);" title="Detail">
                <i class="bi bi-eye"></i>
              </a>
              <?php if ($s['status_penyewaan'] === 'aktif'): ?>
              <a href="<?= $panelBase ?>/pengembalianProses/<?= $s['id_penyewaan'] ?>"
                 class="btn-sm-icon" style="background:#ede9fe;color:#7c3aed;" title="Proses Pengembalian">
                <i class="bi bi-box-arrow-in-left"></i>
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
