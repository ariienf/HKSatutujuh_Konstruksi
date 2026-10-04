<?php
/** @var array $pelanggan */
/** @var string $pageTitle */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item active">Profil Saya</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <h4 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1.5rem;">Profil Saya</h4>

    <?php if (!empty($flash)): ?>
      <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show rounded-3 py-2 px-3 mb-3" style="font-size:0.85rem;">
        <i class="bi bi-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row g-4">
      <!-- DATA DIRI -->
      <div class="col-lg-7">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;">
          <div style="background:var(--steel);padding:1.1rem 1.6rem;border-bottom:3px solid var(--orange);">
            <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:0;">
              <i class="bi bi-person me-2"></i>Data Diri
            </h6>
          </div>
          <div style="padding:1.6rem;">
            <form method="POST" action="<?= BASE_URL ?>/pelanggan/profil">
              <input type="hidden" name="aksi" value="update_profil"/>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Email</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($pelanggan['email']) ?>" disabled
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;background:#f7f4ef;"/>
              </div>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Nama Lengkap</label>
                <input type="text" name="nama_pelanggan" class="form-control" required
                  value="<?= htmlspecialchars($pelanggan['nama_pelanggan']) ?>"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">No. HP</label>
                <input type="text" name="no_hp" class="form-control"
                  value="<?= htmlspecialchars($pelanggan['no_hp'] ?? '') ?>"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" class="form-control"
                  value="<?= htmlspecialchars($pelanggan['nama_perusahaan'] ?? '') ?>"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <div class="mb-4">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;resize:none;"><?= htmlspecialchars($pelanggan['alamat'] ?? '') ?></textarea>
              </div>
              <button type="submit"
                style="background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:10px;padding:0.7rem 1.6rem;font-size:0.9rem;">
                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- UBAH PASSWORD -->
      <div class="col-lg-5">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;">
          <div style="background:var(--steel);padding:1.1rem 1.6rem;border-bottom:3px solid var(--orange);">
            <h6 style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:0;">
              <i class="bi bi-shield-lock me-2"></i>Ubah Password
            </h6>
          </div>
          <div style="padding:1.6rem;">
            <form method="POST" action="<?= BASE_URL ?>/pelanggan/profil">
              <input type="hidden" name="aksi" value="update_password"/>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required minlength="8"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <div class="mb-4">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" class="form-control" required minlength="8"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>
              <button type="submit"
                style="background:var(--steel);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:10px;padding:0.7rem 1.6rem;font-size:0.9rem;">
                <i class="bi bi-key me-2"></i>Ubah Password
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
