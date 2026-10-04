<?php
/** @var array $pembayaran */
/** @var array $detail */
?>

<section style="padding:3rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">

        <!-- STATUS SUKSES -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;text-align:center;">
          <div style="background:var(--steel);padding:2rem;border-bottom:3px solid var(--orange);">
            <div style="width:70px;height:70px;border-radius:50%;background:rgba(34,197,94,0.15);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
              <i class="bi bi-check-circle-fill" style="font-size:2.5rem;color:#22c55e;"></i>
            </div>
            <h4 style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;margin-bottom:0.3rem;">Pembayaran Terkirim!</h4>
            <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;margin:0;">
              Menunggu konfirmasi dari tim kami
            </p>
          </div>

          <div style="padding:1.8rem;">
            <!-- Kode Transaksi -->
            <div style="background:var(--cream);border-radius:10px;padding:1rem;margin-bottom:1.5rem;">
              <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.3rem;">Kode Transaksi</div>
              <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;color:var(--orange);">
                <?= htmlspecialchars($pembayaran['kode_transaksi']) ?>
              </div>
              <div style="font-size:0.75rem;color:var(--muted);margin-top:0.2rem;">
                <?= date('d M Y H:i', strtotime($pembayaran['tanggal_bayar'])) ?> WIB
              </div>
            </div>

            <!-- Detail -->
            <div style="text-align:left;margin-bottom:1.5rem;">
              <?php foreach ($detail as $d): ?>
              <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid #f0ece4;font-size:0.85rem;">
                <span><?= htmlspecialchars($d['nama_alat']) ?> (<?= $d['jumlah'] ?> unit)</span>
                <span style="font-weight:600;">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></span>
              </div>
              <?php endforeach; ?>
              <div style="display:flex;justify-content:space-between;padding:0.7rem 0;font-size:0.95rem;">
                <span style="font-family:'Syne',sans-serif;font-weight:700;">Total Dibayar</span>
                <span style="font-family:'Syne',sans-serif;font-weight:800;color:var(--orange);">
                  Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?>
                </span>
              </div>
            </div>

            <!-- Metode -->
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:0.8rem;margin-bottom:1.5rem;font-size:0.83rem;color:#166534;">
              <i class="bi bi-info-circle me-2"></i>
              Metode: <strong><?= ucfirst(str_replace('_', ' ', $pembayaran['metode_bayar'])) ?></strong>
              — Status: <strong>Menunggu Konfirmasi</strong>
            </div>

            <!-- Bukti -->
            <?php if (!empty($pembayaran['bukti_bayar'])): ?>
            <div style="margin-bottom:1.5rem;">
              <div style="font-size:0.82rem;font-weight:600;color:var(--muted);margin-bottom:0.5rem;">Bukti Pembayaran</div>
              <img src="<?= BASE_URL ?>/public/uploads/bukti/<?= htmlspecialchars($pembayaran['bukti_bayar']) ?>"
                   alt="Bukti" style="max-width:100%;border-radius:8px;border:1px solid #e0dbd2;"/>
            </div>
            <?php endif; ?>

            <!-- Tombol -->
            <div class="d-flex flex-column gap-2">
              <a href="<?= BASE_URL ?>/Penyewaan/riwayat"
                 style="display:block;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border-radius:10px;padding:0.75rem;text-align:center;text-decoration:none;font-size:0.92rem;">
                <i class="bi bi-clock-history me-2"></i>Lihat Riwayat Sewa
              </a>
              <a href="<?= BASE_URL ?>/home/katalog"
                 style="display:block;background:transparent;color:var(--steel);font-weight:600;border-radius:10px;padding:0.7rem;text-align:center;text-decoration:none;border:1.5px solid #e8e3da;font-size:0.88rem;">
                <i class="bi bi-grid me-2"></i>Kembali ke Katalog
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
