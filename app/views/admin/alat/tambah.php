<?php
// File ini digunakan untuk tambah DAN edit
// Jika $alat ada = mode edit, jika tidak = mode tambah
$isEdit    = isset($alat);
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
$actionUrl = $isEdit ? $panelBase.'/alatEdit/'.$alat['id_alat'] : $panelBase.'/alatTambah';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title">
          <i class="bi bi-<?= $isEdit ? 'pencil' : 'plus-lg' ?> me-2" style="color:var(--orange);"></i>
          <?= $isEdit ? 'Edit Alat' : 'Tambah Alat Baru' ?>
        </div>
        <a href="<?= $panelBase ?>/alat" class="btn-admin-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>
      <div class="content-card-body">
        <form method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label-admin">Nama Alat <span style="color:red;">*</span></label>
              <input type="text" name="nama_alat" class="form-control-admin" required
                value="<?= htmlspecialchars($alat['nama_alat'] ?? '') ?>" placeholder="Nama alat konstruksi"/>
            </div>
            <div class="col-md-4">
              <label class="form-label-admin">Jenis / Kategori <span style="color:red;">*</span></label>
              <select name="jenis_alat" class="form-control-admin" required>
                <option value="">Pilih jenis...</option>
                <?php
                $jenisOptions = ['Alat Berat','Alat Listrik','Alat Tangan','Scaffolding','Pompa Air','Generator'];
                foreach ($jenisOptions as $j):
                  $selected = isset($alat) && $alat['jenis_alat'] === $j ? 'selected' : '';
                ?>
                <option value="<?= $j ?>" <?= $selected ?>><?= $j ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-admin">Deskripsi</label>
              <textarea name="deskripsi" class="form-control-admin" rows="3"
                placeholder="Deskripsi singkat alat..."><?= htmlspecialchars($alat['deskripsi'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label-admin">Biaya Sewa / Hari (Rp) <span style="color:red;">*</span></label>
              <input type="number" name="biaya_sewa" class="form-control-admin" required min="0"
                value="<?= $alat['biaya_sewa'] ?? '' ?>" placeholder="150000"/>
            </div>
            <div class="col-md-4">
              <label class="form-label-admin">Minimum Sewa (hari) <span style="color:red;">*</span></label>
              <input type="number" name="minimum_sewa" class="form-control-admin" required min="1"
                value="<?= $alat['minimum_sewa'] ?? 1 ?>"/>
            </div>
            <div class="col-md-4">
              <label class="form-label-admin">Stok <span style="color:red;">*</span></label>
              <input type="number" name="stok" class="form-control-admin" required min="0"
                value="<?= $alat['stok'] ?? 0 ?>"/>
            </div>
            <?php if ($isEdit): ?>
            <div class="col-md-4">
              <label class="form-label-admin">Status</label>
              <select name="status_alat" class="form-control-admin">
                <option value="tersedia" <?= $alat['status_alat']==='tersedia'?'selected':'' ?>>Tersedia</option>
                <option value="habis"    <?= $alat['status_alat']==='habis'?'selected':'' ?>>Habis</option>
                <option value="maintenance" <?= $alat['status_alat']==='maintenance'?'selected':'' ?>>Maintenance</option>
              </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
              <label class="form-label-admin">Gambar Alat <?= $isEdit ? '(kosongkan jika tidak diubah)' : '' ?></label>
              <input type="file" name="gambar_alat" class="form-control-admin" accept="image/*"/>
              <?php if ($isEdit && !empty($alat['gambar_alat'])): ?>
              <div style="margin-top:0.5rem;">
                <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($alat['gambar_alat']) ?>"
                     style="height:80px;border-radius:8px;border:1px solid #e5e7eb;"/>
              </div>
              <?php endif; ?>
            </div>
            <div class="col-12 mt-2">
              <button type="submit" class="btn-admin-primary">
                <i class="bi bi-<?= $isEdit ? 'check-lg' : 'plus-lg' ?>"></i>
                <?= $isEdit ? 'Simpan Perubahan' : 'Tambah Alat' ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>