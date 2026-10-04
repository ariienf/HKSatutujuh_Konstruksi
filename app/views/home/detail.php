<?php $pageTitle = htmlspecialchars($alat['nama_alat']) . ' — HK Satu Tujuh'; ?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home/katalog" style="color:var(--orange);text-decoration:none;">Katalog</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($alat['nama_alat']) ?></li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;">
  <div class="container">
    <div class="row g-4">

      <!-- GAMBAR ALAT -->
      <div class="col-lg-5">
        <div style="background:var(--cream);border-radius:16px;height:470px;display:flex;align-items:center;justify-content:center;border:1.5px solid #e8e3da;overflow:hidden;">
          <?php if (!empty($alat['gambar_alat'])): ?>
            <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($alat['gambar_alat']) ?>" alt="<?= htmlspecialchars($alat['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
          <?php else: ?>
            <i class="bi bi-tools" style="font-size:6rem;color:rgba(26,35,50,0.1);"></i>
          <?php endif; ?>
        </div>
      </div>

      <!-- INFO ALAT -->
      <div class="col-lg-7">
        <div style="background:#fff;border-radius:16px;padding:2rem;border:1.5px solid #e8e3da;height:100%;">
          <div style="font-size:0.72rem;font-weight:700;color:var(--orange);letter-spacing:1px;text-transform:uppercase;margin-bottom:0.5rem;">
            <?= htmlspecialchars($alat['jenis_alat']) ?>
          </div>
          <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.7rem;color:var(--steel);margin-bottom:0.5rem;">
            <?= htmlspecialchars($alat['nama_alat']) ?>
          </h1>

          <!-- Status -->
          <?php if ($alat['status_alat'] === 'tersedia'): ?>
            <span style="background:#d1fae5;color:#065f46;font-size:0.75rem;font-weight:700;padding:0.3rem 0.7rem;border-radius:5px;">
              <i class="bi bi-circle-fill me-1" style="font-size:0.45rem;"></i>Tersedia — <?= $alat['stok'] ?> unit
            </span>
          <?php else: ?>
            <span style="background:#fee2e2;color:#991b1b;font-size:0.75rem;font-weight:700;padding:0.3rem 0.7rem;border-radius:5px;">
              <i class="bi bi-circle-fill me-1" style="font-size:0.45rem;"></i>Stok Habis
            </span>
          <?php endif; ?>

          <hr style="border-color:#e8e3da;margin:1.2rem 0;"/>

          <p style="font-size:0.92rem;color:#555;line-height:1.7;margin-bottom:1.2rem;">
            <?= nl2br(htmlspecialchars($alat['deskripsi'])) ?>
          </p>

          <!-- Info Detail -->
          <div class="row g-3 mb-1.5">
            <div class="col-6">
              <div style="background:var(--cream);border-radius:10px;padding:0.9rem;text-align:center;">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;color:var(--orange);">
                  Rp <?= number_format($alat['biaya_sewa'], 0, ',', '.') ?>
                </div>
                <div style="font-size:0.75rem;color:var(--muted);">per hari</div>
              </div>
            </div>
            <div class="col-6">
              <div style="background:var(--cream);border-radius:10px;padding:0.9rem;text-align:center;">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;color:var(--steel);">
                  <?= $alat['minimum_sewa'] ?> hari
                </div>
                <div style="font-size:0.75rem;color:var(--muted);">minimum sewa</div>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <?php if ($alat['status_alat'] === 'tersedia'): ?>
              <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'pelanggan'): ?>
                <a href="<?= BASE_URL ?>/Penyewaan/form/<?= $alat['id_alat'] ?>"
                   style="display:block;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;font-size:0.95rem;border-radius:10px;padding:0.8rem;text-align:center;text-decoration:none;transition:background .2s;margin-bottom:0.7rem;"
                   onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
                  <i class="bi bi-cart-plus me-2"></i>Sewa Sekarang
                </a>
              <?php else: ?>
                <a href="<?= BASE_URL ?>/auth/login"
                   style="display:block;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;font-size:0.95rem;border-radius:10px;padding:0.8rem;text-align:center;text-decoration:none;margin-bottom:0.7rem;">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Menyewa
                </a>
              <?php endif; ?>
              <a href="<?= BASE_URL ?>/home/katalog"
                 style="display:block;background:transparent;color:var(--steel);font-weight:600;font-size:0.88rem;border-radius:10px;padding:0.7rem;text-align:center;text-decoration:none;border:1.5px solid #e8e3da;">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
              </a>
            <?php else: ?>
              <button disabled style="display:block;width:100%;background:#f3f4f6;color:#9ca3af;font-size:0.95rem;border:none;border-radius:10px;padding:0.8rem;cursor:not-allowed;margin-bottom:0.7rem;">
                <i class="bi bi-clock me-2"></i>Stok Sedang Habis
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- ALAT SEJENIS -->
    <?php if (!empty($alatSejenis)): ?>
    <div class="mt-5">
      <h5 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:1.2rem;">
        Alat Sejenis Lainnya
      </h5>
      <div class="row g-3">
        <?php foreach ($alatSejenis as $sejenis):
          if ($sejenis['id_alat'] == $alat['id_alat']) continue; ?>
        <div class="col-md-4 col-lg-3">
          <a href="<?= BASE_URL ?>/home/detail/<?= $sejenis['id_alat'] ?>"
             style="display:block;background:#fff;border-radius:12px;border:1.5px solid #e8e3da;overflow:hidden;text-decoration:none;color:inherit;transition:all .2s;"
             onmouseover="this.style.borderColor='var(--orange)';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e8e3da';this.style.transform='none'">
            <div style="background:var(--cream);height:150px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
              <?php if (!empty($sejenis['gambar_alat'])): ?>
                <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($sejenis['gambar_alat']) ?>" alt="<?= htmlspecialchars($sejenis['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
              <?php else: ?>
                <i class="bi bi-tools" style="font-size:2.5rem;color:rgba(26,35,50,0.1);"></i>
              <?php endif; ?>
            </div>
            <div style="padding:0.8rem;">
              <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;margin-bottom:0.2rem;"><?= htmlspecialchars($sejenis['nama_alat']) ?></div>
              <div style="font-size:0.8rem;color:var(--orange);font-weight:700;">Rp <?= number_format($sejenis['biaya_sewa'], 0, ',', '.') ?>/hari</div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>
