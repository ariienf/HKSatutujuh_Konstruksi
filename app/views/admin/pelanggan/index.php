<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-people me-2" style="color:var(--orange);"></i>Data Pelanggan</div>
    <form method="GET" style="display:flex;gap:6px;">
      <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama / email..." class="form-control-admin" style="width:220px;"/>
      <button type="submit" class="btn-admin-secondary"><i class="bi bi-search"></i></button>
    </form>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Perusahaan</th><th>Jenis Kelamin</th><th>Terdaftar</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarPelanggan)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:2rem;">Belum ada data pelanggan</td></tr>
        <?php else: ?>
        <?php foreach ($daftarPelanggan as $p): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:0.6rem;">
              <div style="width:32px;height:32px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:0.8rem;flex-shrink:0;">
                <?= strtoupper(substr($p['nama_pelanggan'],0,1)) ?>
              </div>
              <span style="font-weight:600;"><?= htmlspecialchars($p['nama_pelanggan']) ?></span>
            </div>
          </td>
          <td style="font-size:0.83rem;"><?= htmlspecialchars($p['email']) ?></td>
          <td><?= htmlspecialchars($p['no_hp']) ?></td>
          <td><?= htmlspecialchars($p['nama_perusahaan'] ?? '-') ?></td>
          <td><?= htmlspecialchars($p['jenis_kelamin']) ?></td>
          <td style="font-size:0.8rem;color:var(--muted);"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td>
            <div class="d-flex gap-1">
              <a href="<?= $panelBase ?>/pelangganDetail/<?= $p['id_pelanggan'] ?>" class="btn-sm-icon" style="background:#f3f4f6;color:var(--steel);" title="Detail"><i class="bi bi-eye"></i></a>
              <a href="<?= $panelBase ?>/pelangganEdit/<?= $p['id_pelanggan'] ?>" class="btn-sm-icon" style="background:#dbeafe;color:#1e40af;" title="Edit"><i class="bi bi-pencil"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>