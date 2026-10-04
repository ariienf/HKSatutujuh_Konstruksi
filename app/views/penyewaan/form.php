<?php
/** @var array $alat */
/** @var string $pageTitle */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home/katalog" style="color:var(--orange);text-decoration:none;">Katalog</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home/detail/<?= $alat['id_alat'] ?>" style="color:var(--orange);text-decoration:none;"><?= htmlspecialchars($alat['nama_alat']) ?></a></li>
        <li class="breadcrumb-item active">Form Sewa</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row g-4 justify-content-center">

      <!-- FORM SEWA -->
      <div class="col-lg-7">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;">
          <div style="background:var(--steel);padding:1.3rem 1.8rem;border-bottom:3px solid var(--orange);">
            <h5 style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:0;">
              <i class="bi bi-cart-plus me-2"></i>Form Penyewaan
            </h5>
          </div>
          <div style="padding:1.8rem;">
            <form method="POST" action="<?= BASE_URL ?>/Penyewaan/simpan" id="formSewa">
              <input type="hidden" name="id_alat" value="<?= $alat['id_alat'] ?>"/>

              <!-- Info Alat -->
              <div style="background:var(--cream);border-radius:10px;padding:1rem;margin-bottom:1.5rem;display:flex;gap:1rem;align-items:center;">
                <div style="width:60px;height:60px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #e8e3da;flex-shrink:0;overflow:hidden;">
                  <?php if (!empty($alat['gambar_alat'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($alat['gambar_alat']) ?>" alt="<?= htmlspecialchars($alat['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
                  <?php else: ?>
                    <i class="bi bi-tools" style="font-size:1.8rem;color:rgba(26,35,50,0.2);"></i>
                  <?php endif; ?>
                </div>
                <div>
                  <div style="font-size:0.7rem;font-weight:700;color:var(--orange);letter-spacing:1px;text-transform:uppercase;"><?= htmlspecialchars($alat['jenis_alat']) ?></div>
                  <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1rem;"><?= htmlspecialchars($alat['nama_alat']) ?></div>
                  <div style="font-size:0.82rem;color:var(--muted);">Rp <?= number_format($alat['biaya_sewa'], 0, ',', '.') ?>/hari · Min. <?= $alat['minimum_sewa'] ?> hari · Stok: <?= $alat['stok'] ?></div>
                </div>
              </div>

              <!-- Tanggal -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                    Tanggal Mulai Sewa <span style="color:red;">*</span>
                  </label>
                  <input type="date" name="tanggal_sewa" id="tgl_sewa" class="form-control" required
                    min="<?= date('Y-m-d') ?>"
                    style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
                </div>
                <div class="col-md-6">
                  <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                    Tanggal Kembali <span style="color:red;">*</span>
                  </label>
                  <input type="date" name="tanggal_kembali" id="tgl_kembali" class="form-control" required
                    min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                    style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
                </div>
              </div>

              <!-- Jumlah -->
              <div class="mb-3">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                  Jumlah Unit <span style="color:red;">*</span>
                </label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="1"
                  min="1" max="<?= $alat['stok'] ?>" required
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;"/>
                <div style="font-size:0.75rem;color:var(--muted);margin-top:4px;">Maksimal <?= $alat['stok'] ?> unit</div>
              </div>

              <!-- Lokasi -->
              <div class="mb-4">
                <label style="font-size:0.85rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">
                  Lokasi Pengiriman <span style="color:red;">*</span>
                </label>
                <textarea name="lokasi_pengiriman" class="form-control" rows="3" required
                  placeholder="Masukkan alamat lengkap lokasi pengiriman alat..."
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.9rem;padding:0.65rem 1rem;resize:none;"></textarea>
              </div>

              <!-- Ringkasan Harga -->
              <div style="background:var(--cream);border-radius:10px;padding:1rem;margin-bottom:1.5rem;" id="ringkasanHarga">
                <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;margin-bottom:0.8rem;color:var(--steel);">Ringkasan Biaya</div>
                <div class="d-flex justify-content-between mb-1" style="font-size:0.85rem;">
                  <span style="color:var(--muted);">Harga sewa</span>
                  <span>Rp <?= number_format($alat['biaya_sewa'], 0, ',', '.') ?>/hari</span>
                </div>
                <div class="d-flex justify-content-between mb-1" style="font-size:0.85rem;">
                  <span style="color:var(--muted);">Jumlah unit</span>
                  <span id="infoJumlah">1 unit</span>
                </div>
                <div class="d-flex justify-content-between mb-1" style="font-size:0.85rem;">
                  <span style="color:var(--muted);">Lama sewa</span>
                  <span id="infoLama">— hari</span>
                </div>
                <hr style="border-color:#ddd;margin:0.7rem 0;"/>
                <div class="d-flex justify-content-between">
                  <span style="font-weight:700;font-family:'Syne',sans-serif;">Total</span>
                  <span id="infoTotal" style="font-weight:800;font-family:'Syne',sans-serif;color:var(--orange);">—</span>
                </div>
              </div>

              <button type="submit"
                style="width:100%;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:10px;padding:0.8rem;font-size:0.95rem;transition:background .2s;"
                onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
                <i class="bi bi-arrow-right-circle me-2"></i>Lanjut ke Pembayaran
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- SIDEBAR INFO -->
      <div class="col-lg-4">
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;padding:1.4rem;margin-bottom:1rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:1rem;color:var(--steel);">
            <i class="bi bi-info-circle me-2" style="color:var(--orange);"></i>Informasi Penting
          </div>
          <ul style="font-size:0.83rem;color:var(--muted);line-height:1.8;padding-left:1.2rem;margin:0;">
            <li>Pembayaran dilakukan setelah form ini disubmit</li>
            <li>Alat akan dikirim ke lokasi yang Anda masukkan</li>
            <li>Minimum sewa <strong style="color:var(--steel);"><?= $alat['minimum_sewa'] ?> hari</strong></li>
            <li>Denda keterlambatan berlaku jika pengembalian melebihi jadwal</li>
            <li>Pastikan lokasi pengiriman lengkap dan benar</li>
          </ul>
        </div>
        <div style="background:var(--steel);border-radius:14px;padding:1.4rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:0.8rem;color:#fff;">
            <i class="bi bi-headset me-2" style="color:var(--orange);"></i>Butuh Bantuan?
          </div>
          <p style="font-size:0.82rem;color:rgba(255,255,255,0.6);margin-bottom:0.8rem;line-height:1.6;">
            Hubungi kami jika ada pertanyaan seputar penyewaan alat.
          </p>
          <div style="font-size:0.82rem;color:rgba(255,255,255,0.7);">
            <i class="bi bi-whatsapp me-2" style="color:var(--orange);"></i>0822-5870-7017
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
const biayaSewa  = <?= $alat['biaya_sewa'] ?>;
const minSewa    = <?= $alat['minimum_sewa'] ?>;
const tglSewa    = document.getElementById('tgl_sewa');
const tglKembali = document.getElementById('tgl_kembali');
const jumlahInput = document.getElementById('jumlah');

function hitungTotal() {
  const mulai   = new Date(tglSewa.value);
  const kembali = new Date(tglKembali.value);
  const jumlah  = parseInt(jumlahInput.value) || 1;

  if (tglSewa.value && tglKembali.value && kembali > mulai) {
    const lama  = Math.ceil((kembali - mulai) / (1000 * 60 * 60 * 24));
    const total = biayaSewa * jumlah * lama;

    document.getElementById('infoLama').textContent   = lama + ' hari';
    document.getElementById('infoJumlah').textContent = jumlah + ' unit';
    document.getElementById('infoTotal').textContent  = 'Rp ' + total.toLocaleString('id-ID');
  } else {
    document.getElementById('infoLama').textContent   = '— hari';
    document.getElementById('infoTotal').textContent  = '—';
  }
}

tglSewa.addEventListener('change', function() {
  // Set min tanggal kembali
  const minKembali = new Date(this.value);
  minKembali.setDate(minKembali.getDate() + minSewa);
  tglKembali.min = minKembali.toISOString().split('T')[0];
  if (tglKembali.value && tglKembali.value < tglKembali.min) {
    tglKembali.value = tglKembali.min;
  }
  hitungTotal();
});

tglKembali.addEventListener('change', hitungTotal);
jumlahInput.addEventListener('input', hitungTotal);
</script>