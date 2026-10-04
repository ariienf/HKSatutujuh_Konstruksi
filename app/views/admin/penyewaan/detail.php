<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="row g-3">
  <div class="col-lg-8">
    <!-- INFO PENYEWAAN -->
    <div class="content-card mb-3">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-file-text me-2" style="color:var(--orange);"></i><?= htmlspecialchars($sewa['kode_penyewaan']) ?></div>
        <div class="d-flex gap-2 align-items-center">
          <span class="badge-status badge-<?= $sewa['status_penyewaan'] ?>"><?= ucfirst($sewa['status_penyewaan']) ?></span>
          <a href="<?= $panelBase ?>/penyewaan" class="btn-admin-secondary" style="font-size:0.78rem;padding:0.3rem 0.7rem;"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="content-card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div style="font-size:0.75rem;color:var(--muted);">Pelanggan</div>
            <div style="font-weight:600;"><?= htmlspecialchars($sewa['nama_pelanggan']) ?></div>
            <div style="font-size:0.82rem;color:var(--muted);"><?= htmlspecialchars($sewa['email']) ?> · <?= htmlspecialchars($sewa['no_hp']) ?></div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Tanggal Sewa</div>
            <div style="font-weight:600;"><?= date('d M Y', strtotime($sewa['tanggal_sewa'])) ?></div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Tanggal Kembali</div>
            <div style="font-weight:600;"><?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?></div>
          </div>
          <div class="col-md-6">
            <div style="font-size:0.75rem;color:var(--muted);">Lokasi Pengiriman</div>
            <div style="font-weight:600;"><?= htmlspecialchars($sewa['lokasi_pengiriman']) ?></div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Lama Sewa</div>
            <div style="font-weight:600;"><?= $sewa['lama_sewa'] ?> hari</div>
          </div>
          <div class="col-md-3">
            <div style="font-size:0.75rem;color:var(--muted);">Total Harga</div>
            <div style="font-weight:800;color:var(--orange);">Rp <?= number_format($sewa['total_harga'],0,',','.') ?></div>
          </div>
        </div>

        <!-- Detail alat -->
        <hr style="border-color:#f0f0f0;margin:1rem 0;"/>
        <div style="font-size:0.82rem;font-weight:700;margin-bottom:0.7rem;">Alat yang Disewa</div>
        <?php foreach ($detail as $d): ?>
        <div style="display:flex;justify-content:space-between;padding:0.6rem 0;border-bottom:1px solid #f3f4f6;font-size:0.85rem;">
          <span><?= htmlspecialchars($d['nama_alat']) ?> × <?= $d['jumlah'] ?> unit</span>
          <span style="font-weight:700;">Rp <?= number_format($d['subtotal'],0,',','.') ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Update status -->
        <hr style="border-color:#f0f0f0;margin:1rem 0;"/>
        <form method="POST" action="<?= $panelBase ?>/penyewaanStatus/<?= $sewa['id_penyewaan'] ?>" style="display:flex;gap:8px;align-items:center;">
          <label style="font-size:0.83rem;font-weight:600;white-space:nowrap;">Update Status:</label>
          <select name="status" class="form-control-admin" style="width:auto;">
            <?php foreach (['menunggu','diproses','aktif','selesai','dibatalkan'] as $st): ?>
            <option value="<?= $st ?>" <?= $sewa['status_penyewaan']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn-admin-primary" style="white-space:nowrap;">Simpan</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- PEMBAYARAN -->
    <div class="content-card mb-3">
      <div class="content-card-header"><div class="content-card-title"><i class="bi bi-credit-card me-2" style="color:#22c55e;"></i>Pembayaran</div></div>
      <div class="content-card-body">
        <?php if ($pembayaran): ?>
          <div style="font-size:0.83rem;line-height:2;">
            <div>Kode: <strong><?= htmlspecialchars($pembayaran['kode_transaksi']) ?></strong></div>
            <div>Metode: <strong><?= ucfirst(str_replace('_',' ',$pembayaran['metode_bayar'])) ?></strong></div>
            <div>Total: <strong>Rp <?= number_format($pembayaran['total_bayar'],0,',','.') ?></strong></div>
            <div>Status: <span class="badge-status badge-<?= $pembayaran['status_bayar'] ?>"><?= ucfirst($pembayaran['status_bayar']) ?></span></div>
          </div>
          <?php if (!empty($pembayaran['bukti_bayar'])): ?>
          <div style="margin-top:0.8rem;">
            <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.4rem;">Bukti Pembayaran</div>
            <img src="<?= BASE_URL ?>/public/uploads/bukti/<?= htmlspecialchars($pembayaran['bukti_bayar']) ?>"
                 style="width:100%;border-radius:8px;border:1px solid #e5e7eb;"/>
          </div>
          <?php endif; ?>
          <?php if ($pembayaran['status_bayar'] === 'menunggu'): ?>
          <div class="d-flex gap-2 mt-2">
            <a href="<?= $panelBase ?>/pembayaranKonfirmasi/<?= $pembayaran['id_pembayaran'] ?>"
               class="btn-admin-primary" style="flex:1;justify-content:center;"
               onclick="return confirm('Konfirmasi pembayaran ini?')">
              <i class="bi bi-check-lg"></i> Konfirmasi
            </a>
            <a href="<?= $panelBase ?>/pembayaranTolak/<?= $pembayaran['id_pembayaran'] ?>"
               class="btn-admin-danger" style="flex:1;justify-content:center;"
               onclick="return confirm('Tolak pembayaran ini?')">
              <i class="bi bi-x-lg"></i> Tolak
            </a>
          </div>
          <?php endif; ?>
        <?php else: ?>
          <div style="text-align:center;color:var(--muted);font-size:0.83rem;padding:1rem;">Belum ada pembayaran</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- PENGEMBALIAN -->
    <div class="content-card">
      <div class="content-card-header"><div class="content-card-title"><i class="bi bi-box-arrow-in-left me-2" style="color:#8b5cf6;"></i>Pengembalian</div></div>
      <div class="content-card-body">
        <?php if ($pengembalian): ?>
          <div style="font-size:0.83rem;line-height:2;">
            <div>Tgl Kembali: <strong><?= date('d M Y', strtotime($pengembalian['tanggal_pengembalian'])) ?></strong></div>
            <div>Status: <span style="font-weight:700;color:<?= $pengembalian['status_pengembalian']==='tepat_waktu'?'#16a34a':'#dc2626' ?>"><?= ucfirst(str_replace('_',' ',$pengembalian['status_pengembalian'])) ?></span></div>
            <div>Denda: <strong style="color:#dc2626;">Rp <?= number_format($pengembalian['denda'],0,',','.') ?></strong></div>
            <?php if ($pengembalian['keterangan']): ?>
            <div>Keterangan: <?= htmlspecialchars($pengembalian['keterangan']) ?></div>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div style="text-align:center;color:var(--muted);font-size:0.83rem;padding:1rem;">Belum ada pengembalian</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>