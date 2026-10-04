<?php $panelBase = BASE_URL . '/penjualan'; ?>

<div class="row g-3 justify-content-center">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title">
          <i class="bi bi-credit-card me-2" style="color:var(--orange);"></i>
          Detail Pembayaran — <?= htmlspecialchars($pembayaran['kode_transaksi']) ?>
        </div>
        <a href="<?= $panelBase ?>/pembayaran" class="btn-admin-secondary" style="font-size:0.78rem;padding:0.3rem 0.7rem;">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
      <div class="content-card-body">

        <!-- Info pembayaran -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div style="font-size:0.75rem;color:var(--muted);">Pelanggan</div>
            <div style="font-weight:600;"><?= htmlspecialchars($pembayaran['nama_pelanggan']) ?></div>
            <div style="font-size:0.82rem;color:var(--muted);"><?= htmlspecialchars($pembayaran['no_hp']) ?></div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Kode Penyewaan</div>
            <div style="font-weight:600;font-size:0.88rem;"><?= htmlspecialchars($pembayaran['kode_penyewaan']) ?></div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Status</div>
            <span class="badge-status badge-<?= $pembayaran['status_bayar'] ?>"><?= ucfirst($pembayaran['status_bayar']) ?></span>
          </div>
          <div class="col-md-4">
            <div style="font-size:0.75rem;color:var(--muted);">Metode Bayar</div>
            <div style="font-weight:600;"><?= ucfirst(str_replace('_',' ',$pembayaran['metode_bayar'])) ?></div>
          </div>
          <div class="col-md-4">
            <div style="font-size:0.75rem;color:var(--muted);">Tanggal Bayar</div>
            <div style="font-weight:600;"><?= $pembayaran['tanggal_bayar'] ? date('d M Y H:i', strtotime($pembayaran['tanggal_bayar'])) : '-' ?></div>
          </div>
          <div class="col-md-4">
            <div style="font-size:0.75rem;color:var(--muted);">Total Bayar</div>
            <div style="font-weight:800;color:var(--orange);font-size:1.1rem;">Rp <?= number_format($pembayaran['total_bayar'],0,',','.') ?></div>
          </div>
        </div>

        <!-- Detail alat -->
        <hr style="border-color:#f0f0f0;margin:0.8rem 0;"/>
        <div style="font-size:0.82rem;font-weight:700;margin-bottom:0.6rem;">Alat yang Disewa</div>
        <?php foreach ($detail as $d): ?>
        <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid #f3f4f6;font-size:0.85rem;">
          <span><?= htmlspecialchars($d['nama_alat']) ?> × <?= $d['jumlah'] ?> unit</span>
          <span style="font-weight:700;">Rp <?= number_format($d['subtotal'],0,',','.') ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Bukti Pembayaran -->
        <?php if (!empty($pembayaran['bukti_bayar'])): ?>
        <hr style="border-color:#f0f0f0;margin:0.8rem 0;"/>
        <div style="font-size:0.82rem;font-weight:700;margin-bottom:0.7rem;">Bukti Pembayaran</div>
        <div style="text-align:center;">
          <img src="<?= BASE_URL ?>/public/uploads/bukti/<?= htmlspecialchars($pembayaran['bukti_bayar']) ?>"
               style="max-width:100%;max-height:400px;border-radius:10px;border:1px solid #e5e7eb;cursor:pointer;"
               onclick="window.open(this.src,'_blank')" title="Klik untuk perbesar"/>
          <div style="font-size:0.75rem;color:var(--muted);margin-top:0.4rem;">Klik gambar untuk memperbesar</div>
        </div>
        <?php endif; ?>

        <!-- Aksi konfirmasi/tolak -->
        <?php if ($pembayaran['status_bayar'] === 'menunggu'): ?>
        <hr style="border-color:#f0f0f0;margin:1rem 0;"/>
        <div class="d-flex gap-3">
          <a href="<?= $panelBase ?>/pembayaranKonfirmasi/<?= $pembayaran['id_pembayaran'] ?>"
             class="btn-admin-primary" style="flex:1;justify-content:center;padding:0.65rem;"
             onclick="return confirm('Konfirmasi pembayaran ini? Status penyewaan akan berubah menjadi Aktif.')">
            <i class="bi bi-check-circle me-1"></i> Konfirmasi Pembayaran
          </a>
          <a href="<?= $panelBase ?>/pembayaranTolak/<?= $pembayaran['id_pembayaran'] ?>"
             class="btn-admin-danger" style="flex:1;justify-content:center;padding:0.65rem;"
             onclick="return confirm('Tolak pembayaran ini? Penyewaan akan dibatalkan.')">
            <i class="bi bi-x-circle me-1"></i> Tolak Pembayaran
          </a>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
