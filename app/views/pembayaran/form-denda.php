<?php
/** @var array $sewa */
/** @var array $pengembalian */
/** @var string $pageTitle */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/penyewaan/riwayat" style="color:var(--orange);text-decoration:none;">Riwayat Sewa</a></li>
        <li class="breadcrumb-item active">Bayar Denda</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row g-4 justify-content-center">

      <!-- FORM PEMBAYARAN DENDA -->
      <div class="col-lg-7">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;overflow:hidden;">
          <div style="background:#dc2626;padding:1.3rem 1.8rem;">
            <h5 style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;margin:0;">
              <i class="bi bi-exclamation-triangle me-2"></i>Pembayaran Denda Keterlambatan
            </h5>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:0.2rem;">
              <?= htmlspecialchars($sewa['kode_penyewaan']) ?>
            </div>
          </div>
          <div style="padding:1.8rem;">

            <!-- Info denda -->
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:1rem;margin-bottom:1.5rem;font-size:0.85rem;color:#991b1b;">
              Alat dikembalikan pada <strong><?= date('d M Y', strtotime($pengembalian['tanggal_pengembalian'])) ?></strong>,
              melebihi jadwal pengembalian <strong><?= date('d M Y', strtotime($pengembalian['tanggal_kembali'])) ?></strong>.
              Denda keterlambatan sebesar <strong>10% per hari</strong> dari total harga sewa dikenakan untuk penyewaan ini.
            </div>

            <form method="POST" action="<?= BASE_URL ?>/pembayaran/simpanDenda" enctype="multipart/form-data" id="formBayarDenda">
              <input type="hidden" name="id_penyewaan" value="<?= $sewa['id_penyewaan'] ?>"/>

              <!-- Pilih Metode -->
              <div style="margin-bottom:1.5rem;">
                <label style="font-size:0.85rem;font-weight:700;color:var(--steel);margin-bottom:0.8rem;display:block;">
                  Pilih Metode Pembayaran <span style="color:red;">*</span>
                </label>
                <div class="row g-2">
                  <?php
                  $metodes = [
                    ['value' => 'transfer_bank', 'label' => 'Transfer Bank',  'icon' => 'bank',         'desc' => 'BCA, Mandiri, BNI, BRI'],
                    ['value' => 'qris',          'label' => 'QRIS',           'icon' => 'qr-code',      'desc' => 'Semua dompet digital'],
                  ];
                  foreach ($metodes as $m):
                  ?>
                  <div class="col-4">
                    <label style="cursor:pointer;display:block;">
                      <input type="radio" name="metode_bayar" value="<?= $m['value'] ?>" class="d-none metode-radio" required/>
                      <div class="metode-card" data-metode="<?= $m['value'] ?>"
                           style="border:2px solid #e0dbd2;border-radius:10px;padding:0.9rem 0.6rem;text-align:center;transition:all .2s;">
                        <i class="bi bi-<?= $m['icon'] ?>" style="font-size:1.6rem;color:var(--muted);display:block;margin-bottom:0.4rem;"></i>
                        <div style="font-weight:700;font-size:0.82rem;color:var(--steel);"><?= $m['label'] ?></div>
                        <div style="font-size:0.7rem;color:var(--muted);"><?= $m['desc'] ?></div>
                      </div>
                    </label>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Info Transfer Bank -->
              <div id="info_transfer_bank" class="info-metode d-none" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:1rem;margin-bottom:1.2rem;">
                <div style="font-weight:700;font-size:0.85rem;color:#1e40af;margin-bottom:0.6rem;"><i class="bi bi-bank me-2"></i>Rekening Tujuan</div>
                <div style="font-size:0.83rem;color:#1e3a8a;line-height:1.8;">
                  <div><strong>BCA</strong> — 1234567890 a/n HK Satu Tujuh</div>
                  <div><strong>Mandiri</strong> — 0987654321 a/n HK Satu Tujuh</div>
                  <div class="mt-1" style="color:#6b7280;">Nominal transfer harus sesuai total denda</div>
                </div>
              </div>

              <!-- Info QRIS -->
              <div id="info_qris" class="info-metode d-none" style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:1rem;margin-bottom:1.2rem;text-align:center;">
                <div style="font-weight:700;font-size:0.85rem;color:#166534;margin-bottom:0.6rem;"><i class="bi bi-qr-code me-2"></i>Scan QRIS</div>
                <div style="width:120px;height:120px;background:#e5e7eb;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:0.5rem;">
                  <i class="bi bi-qr-code" style="font-size:3rem;color:#9ca3af;"></i>
                </div>
                <div style="font-size:0.78rem;color:#166534;">Scan dengan aplikasi dompet digital</div>
              </div>

              <!-- Info Tunai -->
              <div id="info_tunai" class="info-metode d-none" style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:1rem;margin-bottom:1.2rem;">
                <div style="font-weight:700;font-size:0.85rem;color:#92400e;margin-bottom:0.4rem;"><i class="bi bi-cash-coin me-2"></i>Pembayaran Tunai</div>
                <div style="font-size:0.83rem;color:#92400e;">Pembayaran denda dilakukan langsung di kantor kami. Siapkan uang pas sesuai nominal.</div>
              </div>

              <!-- Upload Bukti -->
              <div id="wrapBukti" class="d-none mb-4">
                <label style="font-size:0.85rem;font-weight:700;color:var(--steel);margin-bottom:0.4rem;display:block;">
                  Upload Bukti Pembayaran <span style="color:red;">*</span>
                </label>
                <input type="file" name="bukti_pembayaran" id="inputBukti" class="form-control" accept="image/jpeg,image/png"
                  style="border-radius:8px;border:1.5px solid #e0dbd2;font-size:0.88rem;"/>
                <div style="font-size:0.75rem;color:var(--muted);margin-top:4px;">Format JPG/PNG, maksimal 2MB</div>
                <!-- Preview -->
                <div id="previewBukti" class="d-none mt-2" style="text-align:center;">
                  <img id="imgPreview" src="" alt="Preview" style="max-height:180px;border-radius:8px;border:1px solid #e0dbd2;"/>
                </div>
              </div>

              <button type="submit"
                style="width:100%;background:#dc2626;color:#fff;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:10px;padding:0.8rem;font-size:0.95rem;transition:background .2s;"
                onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                <i class="bi bi-send me-2"></i>Kirim Pembayaran Denda
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- RINGKASAN -->
      <div class="col-lg-4">
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;position:sticky;top:80px;">
          <div style="background:var(--cream);padding:1rem 1.4rem;border-bottom:1px solid #e8e3da;">
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;">Ringkasan Denda</div>
          </div>
          <div style="padding:1.2rem;">
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.6rem;">
              <span style="color:var(--muted);">Kode Penyewaan</span>
              <span style="font-weight:700;"><?= htmlspecialchars($sewa['kode_penyewaan']) ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.6rem;">
              <span style="color:var(--muted);">Jadwal Kembali</span>
              <span><?= date('d M Y', strtotime($pengembalian['tanggal_kembali'])) ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.6rem;">
              <span style="color:var(--muted);">Tgl Dikembalikan</span>
              <span><?= date('d M Y', strtotime($pengembalian['tanggal_pengembalian'])) ?></span>
            </div>

            <hr style="border-color:#e8e3da;margin:0.8rem 0;"/>
            <div class="d-flex justify-content-between">
              <span style="font-family:'Syne',sans-serif;font-weight:700;">Total Denda</span>
              <span style="font-family:'Syne',sans-serif;font-weight:800;color:#dc2626;font-size:1.1rem;">
                Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?>
              </span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
document.querySelectorAll('.metode-radio').forEach(radio => {
  radio.addEventListener('change', function() {
    document.querySelectorAll('.metode-card').forEach(card => {
      card.style.borderColor = '#e0dbd2';
      card.style.background  = '#fff';
      card.querySelector('i').style.color = 'var(--muted)';
    });
    const card = document.querySelector(`.metode-card[data-metode="${this.value}"]`);
    card.style.borderColor = '#dc2626';
    card.style.background  = '#fef2f2';
    card.querySelector('i').style.color = '#dc2626';

    document.querySelectorAll('.info-metode').forEach(el => el.classList.add('d-none'));
    const info = document.getElementById('info_' + this.value);
    if (info) info.classList.remove('d-none');

    const wrapBukti = document.getElementById('wrapBukti');
    const inputBukti = document.getElementById('inputBukti');
    if (this.value === 'transfer_bank' || this.value === 'qris') {
      wrapBukti.classList.remove('d-none');
      inputBukti.required = true;
    } else {
      wrapBukti.classList.add('d-none');
      inputBukti.required = false;
    }
  });
});

document.getElementById('inputBukti').addEventListener('change', function() {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('imgPreview').src = e.target.result;
      document.getElementById('previewBukti').classList.remove('d-none');
    };
    reader.readAsDataURL(file);
  }
});
</script>
