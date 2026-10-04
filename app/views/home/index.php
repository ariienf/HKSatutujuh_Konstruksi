<?php $pageTitle = 'HK Satu Tujuh — Sewa Alat Konstruksi'; ?>

<style>
  .hero-section {
    background:
      linear-gradient(90deg, rgba(26,35,50,0.92) 0%, rgba(26,35,50,0.8) 45%, rgba(26,35,50,0.55) 100%),
      url('<?= BASE_URL ?>/public/images/hero-bg.jpg') center/cover no-repeat;
    min-height: 82vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }
  .hero-section::before {
    content: '';
    position: absolute;
    right: -80px; top: -80px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: var(--orange);
    opacity: 0.07;
  }
  .hero-label {
    display: inline-block;
    background: rgba(224,90,30,0.15);
    color: var(--orange);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 0.35rem 0.9rem;
    border-radius: 4px;
    margin-bottom: 1.2rem;
    border: 1px solid rgba(224,90,30,0.3);
  }
  .hero-title {
    font-size: clamp(2rem, 5vw, 3.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 1.2rem;
  }
  .hero-title .accent { color: var(--orange); }
  .hero-subtitle {
    color: rgba(255,255,255,0.6);
    font-size: 1rem;
    max-width: 480px;
    margin-bottom: 2rem;
    line-height: 1.7;
  }
  .btn-hero-primary {
    background: var(--orange);
    color: #fff;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    font-size: 0.92rem;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.6rem;
    text-decoration: none;
    transition: all .2s;
    display: inline-block;
  }
  .btn-hero-primary:hover { background: var(--orange-dark); color: #fff; transform: translateY(-1px); }
  .btn-hero-outline {
    background: transparent;
    color: #fff;
    font-size: 0.92rem;
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 8px;
    padding: 0.75rem 1.4rem;
    text-decoration: none;
    transition: all .2s;
    display: inline-block;
  }
  .btn-hero-outline:hover { border-color: #fff; color: #fff; }
  .hero-stat-block { border-left: 2px solid var(--orange); padding-left: 1rem; }
  .hero-image-box {
    background: var(--steel-mid);
    border-radius: 16px;
    height: 360px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid rgba(255,255,255,0.07);
    position: relative;
    overflow: hidden;
  }
  .hero-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .hero-image-box::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,35,50,0.55), transparent 55%);
  }
  .section-label {
    color: var(--orange);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 0.4rem;
  }
  .section-title {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 800;
    color: var(--steel);
    line-height: 1.2;
  }
  .kat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.3rem;
    display: flex; flex-direction: column; align-items: center;
    text-align: center;
    cursor: pointer;
    border: 1.5px solid #e8e3da;
    transition: all .2s;
    text-decoration: none;
    color: inherit;
  }
  .kat-card:hover {
    border-color: var(--orange);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(224,90,30,0.1);
    color: inherit;
  }
  .kat-icon {
    width: 54px; height: 54px;
    background: rgba(224,90,30,0.08);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 0.8rem;
  }
  .alat-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #e8e3da;
    overflow: hidden;
    transition: all .25s;
    height: 100%;
  }
  .alat-card:hover {
    border-color: var(--orange);
    box-shadow: 0 12px 32px rgba(26,35,50,0.1);
    transform: translateY(-4px);
  }
  .alat-img {
    background: var(--cream);
    height: 375px;
    display: flex; align-items: center; justify-content: center;
    border-bottom: 1px solid #e8e3da;
    position: relative;
    overflow: hidden;
  }
  .alat-img img { width: 100%; height: 100%; object-fit: cover; }
  .alat-img .no-img { font-size: 3.5rem; color: rgba(26,35,50,0.12); }
  .badge-tersedia {
    position: absolute; top: 10px; right: 10px;
    background: #d1fae5; color: #065f46;
    font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.55rem; border-radius: 4px;
  }
  .badge-habis {
    position: absolute; top: 10px; right: 10px;
    background: #fee2e2; color: #991b1b;
    font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.55rem; border-radius: 4px;
  }
</style>

<!-- HERO -->
<section class="hero-section">
  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center">
      <div class="col-lg-6 py-5">
        <div class="hero-label"><i class="bi bi-tools me-1"></i> Platform Sewa Alat #1</div>
        <h1 class="hero-title">Sewa <span class="accent">Alat Konstruksi</span> Mudah & Terpercaya</h1>
        <p class="hero-subtitle">Ratusan alat konstruksi berkualitas siap disewa harian, mingguan, hingga bulanan. Proses cepat, harga transparan, pengiriman ke lokasi.</p>
        <div class="d-flex flex-wrap gap-3 mb-4">
          <a href="<?= BASE_URL ?>/home/katalog" class="btn-hero-primary">
            <i class="bi bi-grid me-2"></i>Lihat Katalog
          </a>
          <a href="<?= BASE_URL ?>/home/caraSewa" class="btn-hero-outline">
            <i class="bi bi-play-circle me-2"></i>Cara Sewa
          </a>
        </div>
        <div class="d-flex gap-4">
          <div class="hero-stat-block">
            <div style="font-family:'Syne',sans-serif;font-size:1.7rem;font-weight:800;color:#fff;"><?= $totalAlat ?>+</div>
            <div style="font-size:0.78rem;color:rgba(255,255,255,0.5);">Jenis Alat</div>
          </div>
          <div class="hero-stat-block">
            <div style="font-family:'Syne',sans-serif;font-size:1.7rem;font-weight:800;color:#fff;">500+</div>
            <div style="font-size:0.78rem;color:rgba(255,255,255,0.5);">Pelanggan Aktif</div>
          </div>
          <div class="hero-stat-block">
            <div style="font-family:'Syne',sans-serif;font-size:1.7rem;font-weight:800;color:#fff;">4.9★</div>
            <div style="font-size:0.78rem;color:rgba(255,255,255,0.5);">Rating Kepuasan</div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block py-5">
        <div class="hero-image-box">
          <img src="<?= BASE_URL ?>/public/images/hero-box.jpg" alt="Armada alat konstruksi HK Satu Tujuh"/>
          <div style="position:absolute;bottom:20px;left:20px;z-index:1;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;font-size:0.78rem;padding:0.45rem 0.9rem;border-radius:6px;">
            <i class="bi bi-patch-check-fill me-1"></i> Alat Bergaransi
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KATEGORI -->
<section style="padding:3.5rem 0;background:var(--cream);">
  <div class="container">
    <div class="text-center mb-4">
      <div class="section-label">Temukan Alat</div>
      <h2 class="section-title">Kategori Alat Konstruksi</h2>
    </div>
    <div class="row g-3 justify-content-center">
      <?php
      $ikonKategori = [
        'Alat Berat'    => 'truck',
        'Alat Listrik'  => 'lightning-charge',
        'Alat Tangan'   => 'hammer',
        'Scaffolding'   => 'ladder',
        'Pompa Air'     => 'droplet-half',
        'Generator'     => 'fuel-pump',
      ];
      foreach ($semuaJenis as $kat):
        $jenis = $kat['jenis_alat'];
        $ikon  = $ikonKategori[$jenis] ?? 'tools';
      ?>
      <div class="col-6 col-md-4 col-lg-2">
        <a href="<?= BASE_URL ?>/home/katalog?jenis=<?= urlencode($jenis) ?>" class="kat-card">
          <div class="kat-icon"><i class="bi bi-<?= $ikon ?>" style="font-size:1.7rem;color:var(--orange);"></i></div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:0.2rem;"><?= htmlspecialchars($jenis) ?></div>
          <div style="font-size:0.75rem;color:var(--muted);"><?= $kat['total'] ?? '' ?> alat</div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ALAT TERBARU -->
<section style="padding:3.5rem 0;background:#fff;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <div class="section-label">Katalog</div>
        <h2 class="section-title">Alat Tersedia</h2>
      </div>
      <a href="<?= BASE_URL ?>/home/katalog" style="color:var(--orange);font-weight:600;font-size:0.88rem;text-decoration:none;">
        Lihat semua <i class="bi bi-arrow-right ms-1"></i>
      </a>
    </div>
    <div class="row g-4">
      <?php if (empty($alatTerbaru)): ?>
        <div class="col-12 text-center py-5 text-muted">
          <i class="bi bi-inbox" style="font-size:3rem;opacity:0.3;"></i>
          <p class="mt-2">Belum ada alat tersedia.</p>
        </div>
      <?php else: ?>
        <?php foreach ($alatTerbaru as $alat): ?>
        <div class="col-md-6 col-lg-4">
          <div class="alat-card">
            <div class="alat-img">
              <?php if (!empty($alat['gambar_alat'])): ?>
                <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($alat['gambar_alat']) ?>" alt="<?= htmlspecialchars($alat['nama_alat']) ?>"/>
              <?php else: ?>
                <i class="bi bi-tools no-img"></i>
              <?php endif; ?>
              <?php if ($alat['status_alat'] === 'tersedia'): ?>
                <span class="badge-tersedia"><i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i>Tersedia</span>
              <?php else: ?>
                <span class="badge-habis"><i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i>Habis</span>
              <?php endif; ?>
            </div>
            <div style="padding:1.1rem;">
              <div style="font-size:0.7rem;font-weight:700;color:var(--orange);letter-spacing:1px;text-transform:uppercase;margin-bottom:0.3rem;">
                <?= htmlspecialchars($alat['jenis_alat']) ?>
              </div>
              <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.97rem;margin-bottom:0.4rem;">
                <?= htmlspecialchars($alat['nama_alat']) ?>
              </div>
              <div style="font-size:0.82rem;color:var(--muted);line-height:1.5;margin-bottom:0.9rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                <?= htmlspecialchars($alat['deskripsi']) ?>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.05rem;color:var(--orange);">
                    Rp <?= number_format($alat['biaya_sewa'], 0, ',', '.') ?>
                    <span style="font-family:'DM Sans',sans-serif;font-weight:400;font-size:0.72rem;color:var(--muted);">/ hari</span>
                  </div>
                  <div style="font-size:0.72rem;color:var(--muted);">Min. <?= $alat['minimum_sewa'] ?> hari</div>
                </div>
                <div style="font-size:0.78rem;color:var(--muted);">
                  <i class="bi bi-box-seam me-1"></i>Stok: <?= $alat['stok'] ?>
                </div>
              </div>
              <?php if ($alat['status_alat'] === 'tersedia'): ?>
                <a href="<?= BASE_URL ?>/home/detail/<?= $alat['id_alat'] ?>"
                   style="display:block;background:var(--steel);color:#fff;font-weight:600;font-size:0.85rem;border-radius:8px;padding:0.55rem 1rem;text-align:center;text-decoration:none;transition:background .2s;"
                   onmouseover="this.style.background='var(--orange)'" onmouseout="this.style.background='var(--steel)'">
                  <i class="bi bi-eye me-2"></i>Lihat Detail
                </a>
              <?php else: ?>
                <button disabled style="display:block;width:100%;background:#e5e7eb;color:#9ca3af;font-size:0.85rem;border:none;border-radius:8px;padding:0.55rem 1rem;cursor:not-allowed;">
                  <i class="bi bi-clock me-2"></i>Stok Habis
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section style="background:var(--orange);padding:3.5rem 0;">
  <div class="container text-center">
    <h2 style="font-family:'Syne',sans-serif;font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:#fff;margin-bottom:0.5rem;">
      Siap Mulai Proyek Anda?
    </h2>
    <p style="color:rgba(255,255,255,0.75);font-size:0.97rem;margin-bottom:1.5rem;">
      Daftar gratis dan dapatkan diskon 20% untuk penyewaan pertama Anda.
    </p>
    <?php if (empty($_SESSION['user_role'])): ?>
    <a href="<?= BASE_URL ?>/auth/register"
       style="background:#fff;color:var(--orange);font-weight:800;font-family:'Syne',sans-serif;border-radius:8px;padding:0.75rem 2rem;font-size:0.92rem;text-decoration:none;display:inline-block;transition:all .2s;"
       onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='#fff'">
      <i class="bi bi-rocket-takeoff me-2"></i>Daftar Gratis Sekarang
    </a>
    <?php else: ?>
    <a href="<?= BASE_URL ?>/home/katalog"
       style="background:#fff;color:var(--orange);font-weight:800;font-family:'Syne',sans-serif;border-radius:8px;padding:0.75rem 2rem;font-size:0.92rem;text-decoration:none;display:inline-block;">
      <i class="bi bi-grid me-2"></i>Lihat Katalog Sekarang
    </a>
    <?php endif; ?>
  </div>
</section>
