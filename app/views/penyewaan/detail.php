<?php
/** @var array $sewa */
/** @var array $detail */
/** @var string $pageTitle */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/penyewaan/riwayat" style="color:var(--orange);text-decoration:none;">Riwayat Sewa</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($sewa['kode_penyewaan']) ?></li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">
    <div class="row g-4">

      <!-- KOLOM KIRI — Info Penyewaan -->
      <div class="col-lg-8">

        <!-- Header status -->
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;margin-bottom:1.2rem;">
          <div style="background:var(--steel);padding:1.2rem 1.6rem;border-bottom:3px solid var(--orange);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <div>
              <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;color:#fff;">
                <?= htmlspecialchars($sewa['kode_penyewaan']) ?>
              </div>
              <div style="font-size:0.78rem;color:rgba(255,255,255,0.5);margin-top:0.2rem;">
                Dibuat: <?= date('d M Y H:i', strtotime($sewa['created_at'])) ?> WIB
              </div>
            </div>
            <?php
            $statusConfig = [
              'menunggu'   => ['bg'=>'#fef3c7','color'=>'#92400e','icon'=>'clock',           'label'=>'Menunggu'],
              'diproses'   => ['bg'=>'#dbeafe','color'=>'#1e40af','icon'=>'arrow-repeat',    'label'=>'Diproses'],
              'aktif'      => ['bg'=>'#d1fae5','color'=>'#065f46','icon'=>'check-circle',    'label'=>'Aktif'],
              'selesai'    => ['bg'=>'#f3f4f6','color'=>'#374151','icon'=>'check2-all',      'label'=>'Selesai'],
              'dibatalkan' => ['bg'=>'#fee2e2','color'=>'#991b1b','icon'=>'x-circle',        'label'=>'Dibatalkan'],
            ];
            $st = $statusConfig[$sewa['status_penyewaan']] ?? $statusConfig['menunggu'];
            ?>
            <span style="background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;font-size:0.82rem;font-weight:700;padding:0.4rem 1rem;border-radius:6px;">
              <i class="bi bi-<?= $st['icon'] ?> me-1"></i><?= $st['label'] ?>
            </span>
          </div>

          <!-- Info sewa -->
          <div style="padding:1.4rem 1.6rem;">
            <div class="row g-3">
              <div class="col-md-4">
                <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.2rem;">Tanggal Mulai Sewa</div>
                <div style="font-weight:700;font-size:0.92rem;">
                  <i class="bi bi-calendar3 me-1" style="color:var(--orange);"></i>
                  <?= date('d M Y', strtotime($sewa['tanggal_sewa'])) ?>
                </div>
              </div>
              <div class="col-md-4">
                <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.2rem;">Tanggal Kembali</div>
                <div style="font-weight:700;font-size:0.92rem;">
                  <i class="bi bi-calendar-x me-1" style="color:var(--orange);"></i>
                  <?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?>
                </div>
              </div>
              <div class="col-md-4">
                <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.2rem;">Lama Sewa</div>
                <div style="font-weight:700;font-size:0.92rem;">
                  <i class="bi bi-hourglass-split me-1" style="color:var(--orange);"></i>
                  <?= $sewa['lama_sewa'] ?> hari
                </div>
              </div>
              <div class="col-12">
                <div style="font-size:0.75rem;color:var(--muted);margin-bottom:0.2rem;">Lokasi Pengiriman</div>
                <div style="font-weight:600;font-size:0.9rem;">
                  <i class="bi bi-geo-alt me-1" style="color:var(--orange);"></i>
                  <?= htmlspecialchars($sewa['lokasi_pengiriman']) ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Detail alat yang disewa -->
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;margin-bottom:1.2rem;">
          <div style="padding:1rem 1.6rem;border-bottom:1px solid #f0ece4;">
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.92rem;">
              <i class="bi bi-tools me-2" style="color:var(--orange);"></i>Alat yang Disewa
            </div>
          </div>
          <?php foreach ($detail as $d): ?>
          <div style="padding:1rem 1.6rem;border-bottom:1px solid #f9f7f4;display:flex;align-items:center;gap:1rem;">
            <div style="width:52px;height:52px;background:var(--cream);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid #e8e3da;">
              <?php if (!empty($d['gambar_alat'])): ?>
                <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($d['gambar_alat']) ?>"
                     style="width:100%;height:100%;object-fit:cover;border-radius:10px;"/>
              <?php else: ?>
                <i class="bi bi-tools" style="color:rgba(26,35,50,0.2);font-size:1.4rem;"></i>
              <?php endif; ?>
            </div>
            <div style="flex:1;">
              <div style="font-weight:700;font-size:0.92rem;"><?= htmlspecialchars($d['nama_alat']) ?></div>
              <div style="font-size:0.78rem;color:var(--muted);">
                <?= htmlspecialchars($d['jenis_alat']) ?> ·
                <?= $d['jumlah'] ?> unit ×
                Rp <?= number_format($d['biaya_sewa'],0,',','.') ?>/hari ×
                <?= $sewa['lama_sewa'] ?> hari
              </div>
            </div>
            <div style="font-family:'Syne',sans-serif;font-weight:800;color:var(--orange);font-size:0.95rem;">
              Rp <?= number_format($d['subtotal'],0,',','.') ?>
            </div>
          </div>
          <?php endforeach; ?>

          <!-- Total -->
          <div style="padding:1rem 1.6rem;background:#fafaf8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-family:'Syne',sans-serif;font-weight:700;">Total Harga</span>
            <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:var(--orange);">
              Rp <?= number_format($sewa['total_harga'],0,',','.') ?>
            </span>
          </div>
        </div>

      </div>

      <!-- KOLOM KANAN — Status & Aksi -->
      <div class="col-lg-4">

        <!-- Langkah progres -->
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;padding:1.4rem;margin-bottom:1.2rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:1.2rem;">
            <i class="bi bi-list-check me-2" style="color:var(--orange);"></i>Progres Penyewaan
          </div>
          <?php
          $steps = [
            ['label'=>'Penyewaan Dibuat',    'status'=>['menunggu','diproses','aktif','selesai','dibatalkan']],
            ['label'=>'Menunggu Pembayaran', 'status'=>['menunggu','diproses','aktif','selesai']],
            ['label'=>'Pembayaran Dikonfirmasi','status'=>['aktif','selesai']],
            ['label'=>'Alat Dikirim / Aktif', 'status'=>['aktif','selesai']],
            ['label'=>'Selesai',             'status'=>['selesai']],
          ];
          foreach ($steps as $i => $step):
            $done = in_array($sewa['status_penyewaan'], $step['status']);
            $isCancelled = $sewa['status_penyewaan'] === 'dibatalkan';
          ?>
          <div style="display:flex;gap:0.8rem;align-items:flex-start;margin-bottom:<?= $i < count($steps)-1 ? '0' : '0' ?>;">
            <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
              <div style="width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;
                          background:<?= $isCancelled && $i>0 ? '#fee2e2' : ($done?'var(--orange)':'#f3f4f6') ?>;
                          color:<?= $isCancelled && $i>0 ? '#991b1b' : ($done?'#fff':'#9ca3af') ?>;">
                <?= $done ? '<i class="bi bi-check-lg"></i>' : ($i+1) ?>
              </div>
              <?php if ($i < count($steps)-1): ?>
              <div style="width:2px;height:20px;background:<?= $done?'var(--orange)':'#e5e7eb' ?>;margin:2px 0;"></div>
              <?php endif; ?>
            </div>
            <div style="padding-top:3px;padding-bottom:<?= $i < count($steps)-1 ? '0' : '0' ?>;">
              <div style="font-size:0.83rem;font-weight:<?= $done?'700':'400' ?>;color:<?= $done?'var(--steel)':'#9ca3af' ?>;">
                <?= $step['label'] ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Aksi -->
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;padding:1.4rem;margin-bottom:1.2rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;margin-bottom:1rem;">
            <i class="bi bi-lightning me-2" style="color:var(--orange);"></i>Aksi
          </div>
          <div class="d-flex flex-column gap-2">

            <?php if ($sewa['status_penyewaan'] === 'menunggu' && empty($sewa['status_bayar'])): ?>
            <!-- Belum bayar -->
            <a href="<?= BASE_URL ?>/pembayaran/form/<?= $sewa['id_penyewaan'] ?>"
               style="display:flex;align-items:center;gap:0.6rem;background:var(--orange);color:#fff;font-weight:700;font-family:'Syne',sans-serif;font-size:0.88rem;border-radius:9px;padding:0.65rem 1rem;text-decoration:none;transition:background .2s;"
               onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
              <i class="bi bi-credit-card"></i> Lanjutkan Pembayaran
            </a>
            <?php endif; ?>

            <?php if ($sewa['status_penyewaan'] === 'aktif' || $sewa['status_penyewaan'] === 'selesai'): ?>
            <?php
              // Cek apakah sudah dibayar lunas
              require_once BASE_PATH . '/app/models/Pembayaran.php';
              $cekBayar = (new Pembayaran())->getByPenyewaan($sewa['id_penyewaan']);
              if ($cekBayar && $cekBayar['status_bayar'] === 'lunas'):
            ?>
            <a href="<?= BASE_URL ?>/surat/download/<?= $sewa['id_penyewaan'] ?>"
              style="display:flex;align-items:center;gap:0.6rem;
                      background:#d1fae5;color:#065f46;
                      font-weight:700;font-family:'Syne',sans-serif;
                      font-size:0.88rem;border-radius:9px;
                      padding:0.65rem 1rem;text-decoration:none;
                      border:1px solid #a7f3d0;transition:all .2s;"
              onmouseover="this.style.background='#a7f3d0'"
              onmouseout="this.style.background='#d1fae5'">
              <i class="bi bi-file-earmark-pdf"></i> Download Surat Keterangan
            </a>
            <?php endif; ?>

            <!-- Bisa ajukan pengembalian -->
            <a href="<?= BASE_URL ?>/pengembalian/form/<?= $sewa['id_penyewaan'] ?>"
               style="display:flex;align-items:center;gap:0.6rem;background:var(--steel);color:#fff;font-weight:700;font-family:'Syne',sans-serif;font-size:0.88rem;border-radius:9px;padding:0.65rem 1rem;text-decoration:none;transition:background .2s;"
               onmouseover="this.style.background='#2d3f55'" onmouseout="this.style.background='var(--steel)'">
              <i class="bi bi-box-arrow-in-left"></i> Ajukan Pengembalian
            </a>
            <?php endif; ?>

            <!-- Kembali ke riwayat -->
            <a href="<?= BASE_URL ?>/penyewaan/riwayat"
               style="display:flex;align-items:center;gap:0.6rem;background:#f3f4f6;color:var(--steel);font-weight:600;font-size:0.88rem;border-radius:9px;padding:0.65rem 1rem;text-decoration:none;border:1px solid #e5e7eb;">
              <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>

            <!-- Sewa lagi -->
            <a href="<?= BASE_URL ?>/home/katalog"
               style="display:flex;align-items:center;gap:0.6rem;background:#f3f4f6;color:var(--steel);font-weight:600;font-size:0.88rem;border-radius:9px;padding:0.65rem 1rem;text-decoration:none;border:1px solid #e5e7eb;">
              <i class="bi bi-plus-circle"></i> Sewa Alat Lain
            </a>
          </div>
        </div>

        <!-- Info bantuan -->
        <div style="background:var(--steel);border-radius:14px;padding:1.2rem;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;color:#fff;margin-bottom:0.5rem;">
            <i class="bi bi-headset me-2" style="color:var(--orange);"></i>Butuh Bantuan?
          </div>
          <p style="font-size:0.8rem;color:rgba(255,255,255,0.55);margin-bottom:0.7rem;line-height:1.6;">
            Hubungi kami jika ada pertanyaan tentang penyewaan Anda.
          </p>
          <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);">
            <i class="bi bi-whatsapp me-2" style="color:var(--orange);"></i>0822-5870-7017
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
