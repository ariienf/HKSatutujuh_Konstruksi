<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-tools me-2" style="color:var(--orange);"></i>Data Alat Konstruksi</div>
    <div class="d-flex gap-2 flex-wrap">
      <form method="GET" style="display:flex;gap:6px;">
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari alat..." class="form-control-admin" style="width:200px;"/>
        <button type="submit" class="btn-admin-secondary"><i class="bi bi-search"></i></button>
      </form>
      <a href="<?= $panelBase ?>/alatTambah" class="btn-admin-primary"><i class="bi bi-plus-lg"></i> Tambah Alat</a>
    </div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Gambar</th><th>Nama Alat</th><th>Jenis</th><th>Biaya/Hari</th><th>Min. Sewa</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarAlat)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:2rem;">Belum ada data alat</td></tr>
        <?php else: ?>
        <?php foreach ($daftarAlat as $a): ?>
        <tr>
          <td>
            <?php if (!empty($a['gambar_alat'])): ?>
              <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($a['gambar_alat']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;"/>
            <?php else: ?>
              <div style="width:44px;height:44px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-tools" style="color:#d1d5db;"></i>
              </div>
            <?php endif; ?>
          </td>
          <td style="font-weight:600;"><?= htmlspecialchars($a['nama_alat']) ?></td>
          <td><span style="font-size:0.75rem;background:#f3f4f6;padding:0.2rem 0.5rem;border-radius:4px;"><?= htmlspecialchars($a['jenis_alat']) ?></span></td>
          <td style="font-weight:700;color:var(--orange);">Rp <?= number_format($a['biaya_sewa'],0,',','.') ?></td>
          <td><?= $a['minimum_sewa'] ?> hari</td>
          <td><?= $a['stok'] ?></td>
          <td><span class="badge-status badge-<?= $a['status_alat'] ?>"><?= ucfirst($a['status_alat']) ?></span></td>
          <td>
            <div class="d-flex gap-1">
              <a href="<?= $panelBase ?>/alatEdit/<?= $a['id_alat'] ?>" class="btn-sm-icon" style="background:#dbeafe;color:#1e40af;" title="Edit"><i class="bi bi-pencil"></i></a>
              <a href="<?= $panelBase ?>/alatHapus/<?= $a['id_alat'] ?>" class="btn-sm-icon" style="background:#fee2e2;color:#991b1b;" title="Hapus"
                 onclick="return confirm('Yakin hapus alat ini?')"><i class="bi bi-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>