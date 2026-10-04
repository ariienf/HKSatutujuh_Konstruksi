<?php
/** @var array $sewa */
/** @var array $detail */
/** @var float $estimasiDenda */
/** @var string $statusEstimasi */
/** @var string $today */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/penyewaan/riwayat" style="color:var(--orange);text-decoration:none;">Riwayat Sewa</a></li>
        <li class="breadcrumb-item active">Pengembalian</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row g-4 justify-content-center">

      <!-- FORM PENGEMBALIAN -->
      <div class="col-lg-7">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;">
          <div style="background:var(--steel);padding:1.3rem 1.8rem;border-bottom:3px solid var(--orange);">
            <h5 style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:0;">
              <i class="bi bi-box-arrow-in-left me-2"></i>Form Pengembalian Alat
            </h5>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);margin-top:0.2rem;">
              <?= htmlspecialchars($sewa['kode_penyewaan']) ?>
            </div>
          </div>
          <div style="padding:1.8rem;">

            <!-- Info alat yang dikembalikan -->
            <div style="margin-bottom:1.5rem;">
              <div style="font-size:0.82rem;font-weight:700;color:var(--steel);margin-bottom:0.7rem;">Alat yang Dikembalikan</div>
              <?php foreach ($detail as $d): ?>
              <div style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem;background:var(--cream);border-radius:8px;margin-bottom:0.5rem;">
                <div style="width:38px;height:38px;background:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid #e8e3da;overflow:hidden;">
                  <?php if (!empty($d['gambar_alat'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($d['gambar_alat']) ?>" alt="<?= htmlspecialchars($d['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
                  <?php else: ?>
                    <i class="bi bi-tools" style="color:rgba(26,35,50,0.2);"></i>
                  <?php endif; ?>
                </div>
                <div>
                  <div style="font-weight:600;font-size:0.85rem;"><?= htmlspecialchars($d['nama_alat']) ?></div>
                  <div style="font-size:0.75rem;color:var(--muted);"><?= $d['jumlah'] ?> unit</div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <!-- Info jadwal -->
            <div style="background:<?= $statusEstimasi === 'terlambat' ? '#fef3c7' : '#f0fdf4' ?>;border:1px solid <?= $statusEstimasi === 'terlambat' ? '#fde68a' : '#bbf7d0' ?>;border-radius:10px;padding:1rem;margin-bottom:1.5rem;">
              <div style="font-size:0.83rem;color:<?= $statusEstimasi === 'terlambat' ? '#92400e' : '#166534' ?>;">
                <div style="font-weight:700;margin-bottom:0.4rem;">
                  <i class="bi bi-<?= $statusEstimasi === 'terlambat' ? 'exclamation-triangle' : 'check-circle' ?> me-2"></i>
                  <?= $statusEstimasi === 'terlambat' ? 'Pengembalian Terlambat!' : 'Pengembalian Tepat Waktu' ?>
                </div>
                <div>Jadwal kembali: <strong><?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?></strong></div>
                <?php if ($statusEstimasi === 'terlambat' && $estimasiDenda > 0): ?>
                <div class="mt-1">Estimasi denda hari ini: <strong>Rp <?= number_format($estimasiDenda, 0, ',', '.') ?></strong></div>
                <?php endif; ?>
              </div>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/pengembalian/simpan">
              <input type="hidden" name="id_penyewaan" value="<?= $sewa['id_penyewaan'] ?>"/>

              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                  Tanggal Pengembalian <span style="color:red;">*</span>
                </label>
                <input type="date" name="tanggal_pengembalian" id="tglKembali" class="form-control" required
                  value="<?= $today ?>"
                  min="<?= $sewa['tanggal_sewa'] ?>"
                  max="<?= date('Y-m-d', strtotime('+60 days')) ?>"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
              </div>

              <div class="mb-4">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                  Keterangan <span style="font-weight:400;color:var(--muted);">(opsional)</span>
                </label>
                <textarea name="keterangan" class="form-control" rows="3"
                  placeholder="Kondisi alat saat dikembalikan, catatan kerusakan, dll..."
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.88rem;resize:none;"></textarea>
              </div>

              <!-- Estimasi denda realtime -->
              <div id="infoDenda" style="background:var(--cream);border-radius:10px;padding:1rem;margin-bottom:1.5rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.4rem;">
                  <span style="color:var(--muted);">Total sewa</span>
                  <span>Rp <?= number_format($sewa['total_harga'], 0, ',', '.') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.4rem;">
                  <span style="color:var(--muted);">Denda keterlambatan</span>
                  <span id="nilaiDenda" style="color:#dc2626;font-weight:600;">Rp 0</span>
                </div>
                <hr style="border-color:#ddd;margin:0.6rem 0;"/>
                <div style="display:flex;justify-content:space-between;">
                  <span style="font-family:'Syne',sans-serif;font-weight:700;">Total Tagihan</span>
                  <span id="totalTagihan" style="font-family:'Syne',sans-serif;font-weight:800;color:var(--orange);">
                    Rp <?= number_format($sewa['total_harga'], 0, ',', '.') ?>
                  </span>
                </div>
              </div>

              <button type="submit"
                style="width:100%;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:10px;padding:0.8rem;font-size:0.95rem;transition:background .2s;"
                onclick="return confirm('Konfirmasi pengembalian alat? Pastikan semua alat sudah dikembalikan.')"
                onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
                <i class="bi bi-box-arrow-in-left me-2"></i>Konfirmasi Pengembalian
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- SIDEBAR INFO -->
      <div class="col-lg-4">
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;padding:1.4rem;margin-bottom:1rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:1rem;color:var(--steel);">
            <i class="bi bi-calendar-check me-2" style="color:var(--orange);"></i>Info Penyewaan
          </div>
          <div style="font-size:0.83rem;color:var(--muted);line-height:2;">
            <div><i class="bi bi-hash me-2"></i><?= htmlspecialchars($sewa['kode_penyewaan']) ?></div>
            <div><i class="bi bi-calendar3 me-2"></i><?= date('d M Y', strtotime($sewa['tanggal_sewa'])) ?></div>
            <div><i class="bi bi-calendar-x me-2"></i><?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?> (jadwal)</div>
            <div><i class="bi bi-clock me-2"></i><?= $sewa['lama_sewa'] ?> hari</div>
            <div><i class="bi bi-geo-alt me-2"></i><?= htmlspecialchars($sewa['lokasi_pengiriman']) ?></div>
          </div>
        </div>
        <div style="background:#fee2e2;border-radius:14px;padding:1.2rem;border:1px solid #fecaca;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;color:#991b1b;margin-bottom:0.5rem;">
            <i class="bi bi-exclamation-triangle me-2"></i>Perhatian
          </div>
          <p style="font-size:0.8rem;color:#7f1d1d;line-height:1.6;margin:0;">
            Denda keterlambatan sebesar <strong>10% per hari</strong> dari total harga sewa akan dikenakan jika pengembalian melebihi jadwal.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
const tglJadwal    = '<?= $sewa['tanggal_kembali'] ?>';
const totalSewa    = <?= $sewa['total_harga'] ?>;

document.getElementById('tglKembali').addEventListener('change', function() {
  const jadwal = new Date(tglJadwal);
  const aktual = new Date(this.value);
  let denda = 0;

  if (aktual > jadwal) {
    const selisih = Math.ceil((aktual - jadwal) / (1000 * 60 * 60 * 24));
    denda = selisih * totalSewa * 0.1;
  }

  const total = totalSewa + denda;
  document.getElementById('nilaiDenda').textContent   = 'Rp ' + denda.toLocaleString('id-ID');
  document.getElementById('totalTagihan').textContent = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
