<?php $pageTitle = 'Tentang Kami - HKSATUTUJUH'; ?>

<style>
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
  .tk-hero {
    background: var(--steel);
    padding: 4rem 0 3.5rem;
    position: relative;
    overflow: hidden;
    border-bottom: 2px solid var(--orange);
  }
  .tk-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(224,90,30,0.18), transparent 70%);
    border-radius: 50%;
  }
  .tk-hero-label {
    display: inline-block;
    background: rgba(224,90,30,0.15);
    color: var(--orange);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 0.35rem 0.9rem;
    border-radius: 6px;
    margin-bottom: 1rem;
  }
  .tk-hero-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 1rem;
  }
  .tk-hero-title .accent { color: var(--orange); }
  .tk-hero-sub {
    color: rgba(255,255,255,0.65);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 620px;
    margin: 0 auto;
  }
  .vm-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem 1.8rem;
    border: 1.5px solid #e8e3da;
    height: 100%;
    transition: all .25s;
  }
  .vm-card:hover {
    border-color: var(--orange);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(26,35,50,0.08);
  }
  .vm-icon {
    width: 56px; height: 56px;
    background: rgba(224,90,30,0.1);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.1rem;
  }
  .vm-icon i { font-size: 1.6rem; color: var(--orange); }
  .vm-card h3 {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 0.6rem;
  }
  .vm-card p {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.7;
    margin: 0;
  }
  .value-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.5rem 1.3rem;
    border: 1px solid #e8e3da;
    height: 100%;
    text-align: center;
  }
  .value-card i {
    font-size: 1.9rem;
    color: var(--orange);
    margin-bottom: 0.7rem;
    display: block;
  }
  .value-card h4 {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.97rem;
    margin-bottom: 0.45rem;
  }
  .value-card p {
    font-size: 0.83rem;
    color: var(--muted);
    line-height: 1.6;
    margin: 0;
  }
  .vm-list { list-style: none; padding: 0; margin: 0; }
  .vm-list li {
    display: flex;
    gap: 0.7rem;
    color: var(--muted);
    font-size: 0.88rem;
    line-height: 1.6;
    margin-bottom: 0.8rem;
  }
  .vm-list li:last-child { margin-bottom: 0; }
  .vm-list .num {
    flex-shrink: 0;
    width: 22px; height: 22px;
    background: rgba(224,90,30,0.1);
    color: var(--orange);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    font-weight: 800;
    font-family: 'Syne', sans-serif;
    margin-top: 0.1rem;
  }
  .legal-card {
    background: var(--cream);
    border-radius: 14px;
    padding: 1.5rem 1.3rem;
    border: 1px solid #e8e3da;
    height: 100%;
  }
  .legal-card i {
    font-size: 1.8rem;
    color: var(--orange);
    margin-bottom: 0.7rem;
    display: block;
  }
  .legal-card h4 {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.92rem;
    margin-bottom: 0.4rem;
  }
  .legal-card .status {
    display: inline-block;
    background: #d1fae5;
    color: #065f46;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.15rem 0.6rem;
    border-radius: 4px;
    margin-bottom: 0.4rem;
  }
  .legal-card p {
    font-size: 0.82rem;
    color: var(--muted);
    line-height: 1.5;
    margin: 0;
  }
  .stat-box { text-align: center; }
  .stat-num {
    font-family: 'Syne', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1;
  }
  .stat-label {
    color: rgba(255,255,255,0.6);
    font-size: 0.83rem;
    margin-top: 0.4rem;
  }
</style>

<!-- HERO -->
<section class="tk-hero">
  <div class="container position-relative text-center" style="z-index:2;">
    <div class="tk-hero-label"><i class="bi bi-people me-1"></i> Tentang Kami</div>
    <h1 class="tk-hero-title">Mitra Terpercaya untuk <span class="accent">Setiap Proyek</span> Anda</h1>
    <p class="tk-hero-sub">
      CV. HK Satu Tujuh adalah platform penyewaan alat konstruksi yang menghadirkan kemudahan,
      transparansi, dan kualitas dalam satu tempat. Kami percaya setiap proyek besar
      dimulai dari alat yang tepat dan layanan yang dapat diandalkan.
    </p>
  </div>
</section>

<!-- CERITA KAMI -->
<section style="padding:3.5rem 0;background:var(--cream);">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="section-label">Sejarah Kami</div>
        <h2 class="section-title mb-3">Membangun di Atas Legalitas & Integritas</h2>
        <p style="color:var(--muted);font-size:0.95rem;line-height:1.8;">
          CV. HK Satu Tujuh didirikan pada 3 Mei 2024 berdasarkan Akta Notaris Nomor 8, dan
          disahkan resmi oleh Kementerian Hukum dan HAM Republik Indonesia. Berkedudukan di
          Kota Bandar Lampung, kami hadir sebagai perusahaan kontraktor dan perdagangan umum
          yang berkomitmen menjadi mitra tepercaya bagi instansi pemerintah, badan usaha,
          maupun perorangan.
        </p>
        <p style="color:var(--muted);font-size:0.95rem;line-height:1.8;">
          Meski tergolong perusahaan yang masih muda, kami membangun fondasi usaha di atas
          legalitas yang lengkap dan terverifikasi — mulai dari Nomor Induk Berusaha (NIB)
          melalui sistem OSS, Sertifikat Badan Usaha (SBU) Konstruksi, hingga kepatuhan
          perpajakan dan jaminan sosial ketenagakerjaan. Layanan penyewaan alat konstruksi
          yang Anda temukan di platform ini adalah wujud komitmen kami mempermudah akses
          alat kerja berkualitas, didukung kapasitas kami sebagai kontraktor berpengalaman
          di bidang konstruksi gedung dan bangunan sipil.
        </p>
        <a href="<?= BASE_URL ?>/home/katalog"
           style="display:inline-block;margin-top:0.5rem;background:var(--orange);color:#fff;font-weight:700;font-size:0.9rem;border-radius:8px;padding:0.65rem 1.5rem;text-decoration:none;transition:background .2s;"
           onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
          <i class="bi bi-grid me-2"></i>Jelajahi Katalog
        </a>
      </div>
      <div class="col-lg-6">
        <div style="background:var(--steel);border-radius:18px;padding:2.5rem;color:#fff;position:relative;overflow:hidden;">
          <i class="bi bi-buildings" style="position:absolute;bottom:-20px;right:-10px;font-size:9rem;color:rgba(255,255,255,0.05);"></i>
          <div style="position:relative;z-index:2;">
            <div style="display:flex;align-items:start;gap:1rem;margin-bottom:1.5rem;">
              <i class="bi bi-check-circle-fill" style="color:var(--orange);font-size:1.3rem;"></i>
              <div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:0.2rem;">Berbadan Hukum Resmi</div>
                <div style="color:rgba(255,255,255,0.6);font-size:0.85rem;">CV terdaftar OSS-RBA & bersertifikat SBU Konstruksi.</div>
              </div>
            </div>
            <div style="display:flex;align-items:start;gap:1rem;margin-bottom:1.5rem;">
              <i class="bi bi-check-circle-fill" style="color:var(--orange);font-size:1.3rem;"></i>
              <div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:0.2rem;">Alat Berkualitas</div>
                <div style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Terawat & siap pakai untuk setiap proyek.</div>
              </div>
            </div>
            <div style="display:flex;align-items:start;gap:1rem;margin-bottom:1.5rem;">
              <i class="bi bi-check-circle-fill" style="color:var(--orange);font-size:1.3rem;"></i>
              <div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:0.2rem;">Harga Transparan</div>
                <div style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Tanpa biaya tersembunyi, jelas di awal.</div>
              </div>
            </div>
            <div style="display:flex;align-items:start;gap:1rem;">
              <i class="bi bi-check-circle-fill" style="color:var(--orange);font-size:1.3rem;"></i>
              <div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:0.2rem;">Pengiriman ke Lokasi</div>
                <div style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Alat diantar langsung ke proyek Anda.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VISI & MISI -->
<section style="padding:3.5rem 0;background:#fff;">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Arah Kami</div>
      <h2 class="section-title">Visi &amp; Misi</h2>
    </div>
    <div class="row g-4">
      <div class="col-md-6">
        <div class="vm-card">
          <div class="vm-icon"><i class="bi bi-eye"></i></div>
          <h3>Visi</h3>
          <p>
            Menjadi perusahaan kontraktor dan perdagangan umum yang profesional, berdaya
            saing, dan tepercaya di Provinsi Lampung serta tingkat nasional — dengan
            mengutamakan kualitas, ketepatan waktu, dan kepuasan pemberi kerja.
          </p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="vm-card">
          <div class="vm-icon"><i class="bi bi-flag"></i></div>
          <h3>Misi</h3>
          <ol class="vm-list">
            <li><span class="num">1</span><span>Melaksanakan pekerjaan konstruksi sesuai standar mutu, K3, dan spesifikasi teknis yang ditetapkan.</span></li>
            <li><span class="num">2</span><span>Menyelesaikan setiap proyek dengan prinsip tepat mutu, tepat biaya, dan tepat waktu.</span></li>
            <li><span class="num">3</span><span>Mengembangkan sumber daya manusia yang kompeten dan bersertifikat.</span></li>
            <li><span class="num">4</span><span>Membangun kemitraan jangka panjang dengan pemberi kerja, mitra, dan pemasok.</span></li>
            <li><span class="num">5</span><span>Menerapkan tata kelola usaha yang taat hukum dan bertanggung jawab.</span></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- NILAI KAMI -->
<section style="padding:3.5rem 0;background:var(--cream);">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Yang Kami Junjung</div>
      <h2 class="section-title">Nilai-Nilai Kami</h2>
    </div>
    <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5">
      <?php
      $values = [
        ['shield-check', 'Integritas', 'Berpegang teguh pada kejujuran dan transparansi dalam setiap pekerjaan.'],
        ['award', 'Kualitas', 'Menjaga standar mutu terbaik pada setiap alat dan hasil pekerjaan.'],
        ['clock-history', 'Tepat Waktu', 'Menyelesaikan proyek dan pengiriman alat sesuai jadwal yang disepakati.'],
        ['cone-striped', 'K3 / Safety', 'Mengutamakan keselamatan & kesehatan kerja di setiap tahapan.'],
        ['briefcase', 'Profesional', 'Ditangani tenaga kerja yang kompeten dan bersertifikat.'],
      ];
      foreach ($values as $v):
      ?>
      <div class="col">
        <div class="value-card">
          <i class="bi bi-<?= $v[0] ?>"></i>
          <h4><?= $v[1] ?></h4>
          <p><?= $v[2] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- LEGALITAS -->
<section style="padding:3.5rem 0;background:#fff;">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Kredibilitas Usaha</div>
      <h2 class="section-title">Legalitas Resmi & Tersertifikasi</h2>
      <p style="color:var(--muted);font-size:0.92rem;max-width:600px;margin:0.8rem auto 0;">
        CV. HK Satu Tujuh terdaftar resmi dan memenuhi seluruh kelengkapan perizinan usaha
        sesuai ketentuan yang berlaku — dapat diverifikasi melalui sistem OSS dan LPJK.
      </p>
    </div>
    <div class="row g-3">
      <?php
      $legalitas = [
        ['patch-check', 'NIB — OSS-RBA', 'Terdaftar', 'Perizinan berusaha berbasis risiko, terbit resmi melalui sistem OSS.'],
        ['award', 'SBU Konstruksi', 'Aktif', '6 subklasifikasi bidang gedung & sipil, diterbitkan LPJK melalui GAPEKNAS.'],
        ['receipt', 'PKP / Pajak', 'Patuh', 'Terdaftar Pengusaha Kena Pajak dengan pelaporan SPT yang tertib.'],
        ['shield-plus', 'BPJS Ketenagakerjaan', 'Aktif', 'Seluruh tenaga kerja terlindungi program JKK & JKM.'],
      ];
      foreach ($legalitas as $l):
      ?>
      <div class="col-md-6 col-lg-3">
        <div class="legal-card">
          <i class="bi bi-<?= $l[0] ?>"></i>
          <div class="status"><?= $l[2] ?></div>
          <h4><?= $l[1] ?></h4>
          <p><?= $l[3] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- STATISTIK -->
<section style="padding:3rem 0;background:var(--steel);">
  <div class="container">
    <div class="row g-4">
      <div class="col-6 col-md-3">
        <div class="stat-box">
          <div class="stat-num"><?= (int)($totalAlat ?? 0) ?>+</div>
          <div class="stat-label">Alat Tersedia</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-box">
          <div class="stat-num">100%</div>
          <div class="stat-label">Alat Terawat</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-box">
          <div class="stat-num">24/7</div>
          <div class="stat-label">Dukungan Online</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-box">
          <div class="stat-num">1<span style="color:var(--orange);">7</span></div>
          <div class="stat-label">Komitmen Kami</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section style="background:var(--orange);padding:3.5rem 0;">
  <div class="container text-center">
    <h2 style="font-family:'Syne',sans-serif;font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:#fff;margin-bottom:0.5rem;">
      Punya Pertanyaan untuk Kami?
    </h2>
    <p style="color:rgba(255,255,255,0.75);font-size:0.97rem;margin-bottom:1.5rem;">
      Hubungi tim kami atau langsung jelajahi katalog alat konstruksi yang tersedia.
    </p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="<?= BASE_URL ?>/home/katalog"
         style="background:#fff;color:var(--orange);font-weight:800;font-family:'Syne',sans-serif;border-radius:8px;padding:0.75rem 2rem;font-size:0.92rem;text-decoration:none;display:inline-block;transition:all .2s;"
         onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='#fff'">
        <i class="bi bi-grid me-2"></i>Lihat Katalog
      </a>
      <a href="mailto:hksatutujuh2024@gmail.com"
         style="background:transparent;border:1.5px solid rgba(255,255,255,0.6);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border-radius:8px;padding:0.75rem 2rem;font-size:0.92rem;text-decoration:none;display:inline-block;transition:all .2s;"
         onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='transparent'">
        <i class="bi bi-envelope me-2"></i>Hubungi Kami
      </a>
    </div>
  </div>
</section>
