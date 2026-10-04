<?php $pageTitle = 'Cara Sewa - HKSATUTUJUH'; ?>

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
  .cs-hero {
    background: var(--steel);
    padding: 4rem 0 3.5rem;
    position: relative;
    overflow: hidden;
    border-bottom: 2px solid var(--orange);
  }
  .cs-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(224,90,30,0.18), transparent 70%);
    border-radius: 50%;
  }
  .cs-hero-label {
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
  .cs-hero-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 1rem;
  }
  .cs-hero-title .accent { color: var(--orange); }
  .cs-hero-sub {
    color: rgba(255,255,255,0.65);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 620px;
    margin: 0 auto;
  }
  .step-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.8rem 1.5rem;
    border: 1px solid #e8e3da;
    height: 100%;
    transition: all .25s;
  }
  .step-card:hover {
    border-color: var(--orange);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(26,35,50,0.08);
  }
  .step-num {
    font-family: 'Syne', sans-serif;
    font-size: 2.8rem; font-weight: 800;
    color: rgba(224,90,30,0.1);
    line-height: 1; margin-bottom: 0.7rem;
  }
  .faq-item {
    background: #fff;
    border-radius: 12px;
    border: 1.5px solid #e8e3da;
    padding: 1.2rem 1.4rem;
    margin-bottom: 0.9rem;
  }
  .faq-item h4 {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 0.4rem;
    color: var(--steel);
  }
  .faq-item p {
    font-size: 0.85rem;
    color: var(--muted);
    line-height: 1.6;
    margin: 0;
  }
</style>

<!-- HERO -->
<section class="cs-hero">
  <div class="container position-relative text-center" style="z-index:2;">
    <div class="cs-hero-label"><i class="bi bi-signpost-split me-1"></i> Panduan</div>
    <h1 class="cs-hero-title">Cara <span class="accent">Menyewa Alat</span></h1>
    <p class="cs-hero-sub">
      Hanya 4 langkah mudah untuk mendapatkan alat konstruksi yang Anda butuhkan
      cepat, transparan, dan tanpa ribet.
    </p>
  </div>
</section>

<!-- LANGKAH -->
<section style="padding:4rem 0;background:var(--cream);">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Proses Mudah</div>
      <h2 class="section-title">Cara Menyewa Alat</h2>
    </div>
    <div class="row g-4">
      <?php
      $steps = [
        ['01', 'person-plus', 'Daftar & Login', 'Buat akun gratis dengan data diri dan KTP. Verifikasi cepat dalam hitungan menit.'],
        ['02', 'search', 'Pilih Alat', 'Telusuri katalog, pilih alat yang dibutuhkan, tentukan tanggal dan durasi sewa.'],
        ['03', 'credit-card', 'Bayar', 'Bayar dengan transfer bank, QRIS, atau tunai. Pembayaran aman dan terenkripsi.'],
        ['04', 'box2-heart', 'Alat Diantar', 'Alat dikirim ke lokasi proyek Anda. Kembalikan saat sewa selesai atau perpanjang.'],
      ];
      foreach ($steps as $step):
      ?>
      <div class="col-md-6 col-lg-3">
        <div class="step-card position-relative">
          <div class="step-num"><?= $step[0] ?></div>
          <i class="bi bi-<?= $step[1] ?>" style="font-size:2rem;color:var(--orange);margin-bottom:0.7rem;display:block;"></i>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.97rem;margin-bottom:0.5rem;"><?= $step[2] ?></div>
          <div style="font-size:0.83rem;color:var(--muted);line-height:1.6;"><?= $step[3] ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ SINGKAT -->
<section style="padding:3.5rem 0;background:#fff;">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Sering Ditanyakan</div>
      <h2 class="section-title">Pertanyaan Umum</h2>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="faq-item">
          <h4><i class="bi bi-question-circle me-2" style="color:var(--orange);"></i>Berapa lama proses verifikasi akun?</h4>
          <p>Verifikasi akun biasanya hanya butuh beberapa menit setelah Anda melengkapi data diri dan foto KTP saat registrasi.</p>
        </div>
        <div class="faq-item">
          <h4><i class="bi bi-question-circle me-2" style="color:var(--orange);"></i>Metode pembayaran apa saja yang tersedia?</h4>
          <p>Kami menerima transfer bank, QRIS, dan pembayaran tunai saat alat diantarkan ke lokasi Anda.</p>
        </div>
        <div class="faq-item">
          <h4><i class="bi bi-question-circle me-2" style="color:var(--orange);"></i>Apakah ada denda jika terlambat mengembalikan?</h4>
          <p>Ya, keterlambatan pengembalian akan dikenakan denda 10% per hari dari total harga sewa alat.</p>
        </div>
        <div class="faq-item" style="margin-bottom:0;">
          <h4><i class="bi bi-question-circle me-2" style="color:var(--orange);"></i>Bagaimana jika alat butuh diperpanjang masa sewanya?</h4>
          <p>Hubungi tim kami sebelum tanggal pengembalian untuk memperpanjang masa sewa sesuai kebutuhan proyek Anda.</p>
        </div>
      </div>
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
