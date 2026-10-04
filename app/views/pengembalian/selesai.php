<?php /** @var array $pengembalian */ ?>

<section style="padding:3rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;text-align:center;">
          <div style="background:var(--steel);padding:2rem;border-bottom:3px solid var(--orange);">
            <div style="width:70px;height:70px;border-radius:50%;background:rgba(34,197,94,0.15);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
              <i class="bi bi-box-arrow-in-left" style="font-size:2.5rem;color:#22c55e;"></i>
            </div>
            <h4 style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;margin-bottom:0.3rem;">Pengembalian Dicatat!</h4>
            <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;margin:0;">Terima kasih telah menggunakan layanan kami</p>
          </div>
          <div style="padding:2rem;">
            <!-- Info -->
            <div style="background:var(--cream);border-radius:10px;padding:1.2rem;margin-bottom:1.5rem;text-align:left;">
              <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                <span style="color:var(--muted);">Kode Penyewaan</span>
                <span style="font-weight:700;"><?= htmlspecialchars($pengembalian['kode_penyewaan']) ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                <span style="color:var(--muted);">Tanggal Kembali</span>
                <span style="font-weight:700;"><?= date('d M Y', strtotime($pengembalian['tanggal_pengembalian'])) ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                <span style="color:var(--muted);">Status</span>
                <span style="font-weight:700;color:<?= $pengembalian['status_pengembalian'] === 'tepat_waktu' ? '#16a34a' : '#dc2626' ?>;">
                  <?= $pengembalian['status_pengembalian'] === 'tepat_waktu' ? 'Tepat Waktu ✓' : 'Terlambat' ?>
                </span>
              </div>
              <?php if ($pengembalian['denda'] > 0): ?>
              <div class="d-flex justify-content-between" style="font-size:0.85rem;">
                <span style="color:var(--muted);">Denda</span>
                <span style="font-weight:700;color:#dc2626;">Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?></span>
              </div>
              <?php endif; ?>
            </div>

            <div class="d-flex flex-column gap-2">
              <?php if ($pengembalian['denda'] > 0): ?>
              <a href="<?= BASE_URL ?>/pembayaran/formDenda/<?= $pengembalian['id_penyewaan'] ?>"
                 style="display:block;background:#dc2626;color:#fff;font-weight:700;font-family:'Syne',sans-serif;border-radius:10px;padding:0.75rem;text-align:center;text-decoration:none;font-size:0.92rem;">
                <i class="bi bi-exclamation-triangle me-2"></i>Bayar Denda Sekarang
              </a>
              <?php endif; ?>
              <a href="<?= BASE_URL ?>/penyewaan/riwayat"
                 style="display:block;background:<?= $pengembalian['denda'] > 0 ? 'transparent' : 'var(--orange)' ?>;color:<?= $pengembalian['denda'] > 0 ? 'var(--steel)' : '#fff' ?>;font-weight:700;font-family:'Syne',sans-serif;border-radius:10px;padding:0.75rem;text-align:center;text-decoration:none;font-size:0.92rem;<?= $pengembalian['denda'] > 0 ? 'border:1.5px solid #e8e3da;' : '' ?>">
                <i class="bi bi-clock-history me-2"></i>Lihat Riwayat Sewa
              </a>
              <a href="<?= BASE_URL ?>/home/katalog"
                 style="display:block;background:transparent;color:var(--steel);font-weight:600;border-radius:10px;padding:0.7rem;text-align:center;text-decoration:none;border:1.5px solid #e8e3da;font-size:0.88rem;">
                <i class="bi bi-grid me-2"></i>Sewa Alat Lagi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
