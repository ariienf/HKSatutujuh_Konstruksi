<?php $panelBase = BASE_URL . '/penjualan'; ?>

<div class="row g-3 justify-content-center">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title">
          <i class="bi bi-box-arrow-in-left me-2" style="color:var(--orange);"></i>
          Proses Pengembalian — <?= htmlspecialchars($sewa['kode_penyewaan']) ?>
        </div>
        <a href="<?= $panelBase ?>/pengembalian" class="btn-admin-secondary" style="font-size:0.78rem;padding:0.3rem 0.7rem;">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
      <div class="content-card-body">

        <!-- Info pelanggan -->
        <div style="background:#f9fafb;border-radius:10px;padding:1rem;margin-bottom:1.3rem;display:flex;gap:1rem;align-items:center;">
          <div style="width:44px;height:44px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:1rem;flex-shrink:0;">
            <?= strtoupper(substr($sewa['nama_pelanggan'],0,1)) ?>
          </div>
          <div>
            <div style="font-weight:700;"><?= htmlspecialchars($sewa['nama_pelanggan']) ?></div>
            <div style="font-size:0.82rem;color:var(--muted);"><?= htmlspecialchars($sewa['no_hp'] ?? '') ?></div>
            <div style="font-size:0.82rem;color:var(--muted);">Sewa: <?= date('d M Y', strtotime($sewa['tanggal_sewa'])) ?> — Jadwal kembali: <strong style="color:<?= strtotime($sewa['tanggal_kembali'])<time()?'#ef4444':'var(--steel)' ?>"><?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?></strong></div>
          </div>
        </div>

        <!-- Alat yang dikembalikan -->
        <div style="font-size:0.82rem;font-weight:700;margin-bottom:0.6rem;">Alat yang Dikembalikan</div>
        <?php foreach ($detail as $d): ?>
        <div style="display:flex;align-items:center;gap:0.7rem;padding:0.6rem;background:#f9fafb;border-radius:8px;margin-bottom:0.4rem;">
          <div style="width:34px;height:34px;background:#fff;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;flex-shrink:0;overflow:hidden;">
            <?php if (!empty($d['gambar_alat'])): ?>
              <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($d['gambar_alat']) ?>" alt="<?= htmlspecialchars($d['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
            <?php else: ?>
              <i class="bi bi-tools" style="color:#d1d5db;"></i>
            <?php endif; ?>
          </div>
          <div>
            <div style="font-weight:600;font-size:0.85rem;"><?= htmlspecialchars($d['nama_alat']) ?></div>
            <div style="font-size:0.75rem;color:var(--muted);"><?= $d['jumlah'] ?> unit</div>
          </div>
        </div>
        <?php endforeach; ?>

        <!-- Estimasi denda -->
        <?php if ($statusEstimasi === 'terlambat'): ?>
        <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:0.8rem;margin:1rem 0;font-size:0.83rem;color:#92400e;">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>Terlambat!</strong> Estimasi denda jika dikembalikan hari ini:
          <strong>Rp <?= number_format($estimasiDenda,0,',','.') ?></strong>
        </div>
        <?php else: ?>
        <div style="background:#d1fae5;border:1px solid #a7f3d0;border-radius:8px;padding:0.8rem;margin:1rem 0;font-size:0.83rem;color:#065f46;">
          <i class="bi bi-check-circle me-2"></i>Pengembalian tepat waktu — tidak ada denda.
        </div>
        <?php endif; ?>

        <!-- Form proses -->
        <form method="POST" action="<?= $panelBase ?>/pengembalianProses/<?= $sewa['id_penyewaan'] ?>">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-admin">Tanggal Pengembalian <span style="color:red;">*</span></label>
              <input type="date" name="tanggal_pengembalian" id="tglKembali" class="form-control-admin" required
                value="<?= $today ?>"
                min="<?= $sewa['tanggal_sewa'] ?>"/>
            </div>
            <div class="col-12">
              <label class="form-label-admin">Keterangan Kondisi Alat</label>
              <textarea name="keterangan" class="form-control-admin" rows="3"
                placeholder="Kondisi alat, kerusakan, catatan lain..."></textarea>
            </div>

            <!-- Preview denda realtime -->
            <div class="col-12">
              <div style="background:#f9fafb;border-radius:10px;padding:1rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.4rem;">
                  <span style="color:var(--muted);">Total sewa</span>
                  <span>Rp <?= number_format($sewa['total_harga'],0,',','.') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.4rem;">
                  <span style="color:var(--muted);">Denda keterlambatan</span>
                  <span id="nilaiDenda" style="color:#dc2626;font-weight:600;">Rp 0</span>
                </div>
                <hr style="border-color:#e5e7eb;margin:0.5rem 0;"/>
                <div style="display:flex;justify-content:space-between;font-weight:700;">
                  <span>Total Tagihan</span>
                  <span id="totalTagihan" style="color:var(--orange);">Rp <?= number_format($sewa['total_harga'],0,',','.') ?></span>
                </div>
              </div>
            </div>

            <div class="col-12">
              <button type="submit" class="btn-admin-primary" style="width:100%;justify-content:center;padding:0.7rem;"
                onclick="return confirm('Proses pengembalian alat ini? Stok akan dikembalikan.')">
                <i class="bi bi-box-arrow-in-left me-2"></i>Konfirmasi Pengembalian
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
const tglJadwal    = '<?= $sewa['tanggal_kembali'] ?>';
const totalSewa    = <?= $sewa['total_harga'] ?>;

document.getElementById('tglKembali').addEventListener('change', function() {
  const jadwal = new Date(tglJadwal);
  const aktual = new Date(this.value);
  let denda = 0;
  if (aktual > jadwal) {
    const selisih = Math.ceil((aktual - jadwal) / (1000*60*60*24));
    denda = selisih * totalSewa * 0.1;
  }
  const total = totalSewa + denda;
  document.getElementById('nilaiDenda').textContent   = 'Rp ' + denda.toLocaleString('id-ID');
  document.getElementById('totalTagihan').textContent = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
