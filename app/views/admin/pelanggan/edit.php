<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-pencil me-2" style="color:var(--orange);"></i>Edit Pelanggan</div>
        <a href="<?= $panelBase ?>/pelangganDetail/<?= $pelanggan['id_pelanggan'] ?>" class="btn-admin-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>
      <div class="content-card-body">
        <form method="POST" action="<?= $panelBase ?>/pelangganEdit/<?= $pelanggan['id_pelanggan'] ?>">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-admin">Email</label>
              <input type="text" class="form-control-admin" value="<?= htmlspecialchars($pelanggan['email']) ?>" disabled/>
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">Nama Lengkap <span style="color:red;">*</span></label>
              <input type="text" name="nama_pelanggan" class="form-control-admin" required
                value="<?= htmlspecialchars($pelanggan['nama_pelanggan']) ?>"/>
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">No. HP</label>
              <input type="text" name="no_hp" class="form-control-admin"
                value="<?= htmlspecialchars($pelanggan['no_hp']) ?>"/>
            </div>
            <div class="col-md-6">
              <label class="form-label-admin">Nama Perusahaan</label>
              <input type="text" name="nama_perusahaan" class="form-control-admin"
                value="<?= htmlspecialchars($pelanggan['nama_perusahaan'] ?? '') ?>"/>
            </div>
            <div class="col-12">
              <label class="form-label-admin">Alamat</label>
              <textarea name="alamat" class="form-control-admin" rows="3"><?= htmlspecialchars($pelanggan['alamat'] ?? '') ?></textarea>
            </div>
            <div class="col-12 mt-2">
              <button type="submit" class="btn-admin-primary">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
