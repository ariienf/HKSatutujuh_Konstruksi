<?php
/** @var array $daftarSewa */
/** @var string $pageTitle */
?>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item active">Riwayat Sewa</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;background:var(--cream);">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <div>
        <h4 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:0.2rem;">Riwayat Penyewaan</h4>
        <div style="font-size:0.85rem;color:var(--muted);">Halo, <?= htmlspecialchars($_SESSION['user_nama']) ?></div>
      </div>
      <a href="<?= BASE_URL ?>/home/katalog"
         style="background:var(--orange);color:#fff;font-weight:600;font-size:0.85rem;border-radius:8px;padding:0.5rem 1.2rem;text-decoration:none;">
        <i class="bi bi-plus-circle me-1"></i>Sewa Alat Baru
      </a>
    </div>

    <?php if (empty($daftarSewa)): ?>
      <div style="background:#fff;border-radius:16px;border:1.5px solid #e8e3da;padding:4rem;text-align:center;">
        <i class="bi bi-inbox" style="font-size:4rem;color:#ddd;"></i>
        <p style="color:var(--muted);margin-top:1rem;margin-bottom:1.5rem;">Anda belum pernah melakukan penyewaan.</p>
        <a href="<?= BASE_URL ?>/home/katalog"
           style="background:var(--orange);color:#fff;font-weight:600;border-radius:8px;padding:0.6rem 1.5rem;text-decoration:none;font-size:0.9rem;">
          Mulai Sewa Sekarang
        </a>
      </div>

    <?php else: ?>
      <div class="d-flex flex-column gap-3">
        <?php foreach ($daftarSewa as $sewa): ?>
        <?php
          $statusColor = [
            'menunggu'   => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'clock'],
            'diproses'   => ['bg' => '#dbeafe', 'text' => '#1e40af', 'icon' => 'arrow-repeat'],
            'aktif'      => ['bg' => '#d1fae5', 'text' => '#065f46', 'icon' => 'check-circle'],
            'selesai'    => ['bg' => '#f3f4f6', 'text' => '#374151', 'icon' => 'check2-all'],
            'dibatalkan' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'x-circle'],
          ];
          $st = $statusColor[$sewa['status_penyewaan']] ?? $statusColor['menunggu'];
        ?>
        <div style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;">
          <!-- Header kartu -->
          <div style="padding:1rem 1.4rem;border-bottom:1px solid #f0ece4;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <div>
              <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;"><?= htmlspecialchars($sewa['kode_penyewaan']) ?></span>
              <span style="font-size:0.78rem;color:var(--muted);margin-left:0.6rem;"><?= date('d M Y', strtotime($sewa['created_at'])) ?></span>
            </div>
            <span style="background:<?= $st['bg'] ?>;color:<?= $st['text'] ?>;font-size:0.75rem;font-weight:700;padding:0.25rem 0.7rem;border-radius:5px;">
              <i class="bi bi-<?= $st['icon'] ?> me-1"></i><?= ucfirst($sewa['status_penyewaan']) ?>
            </span>
          </div>

          <!-- Detail alat -->
          <div style="padding:1rem 1.4rem;">
            <?php foreach ($sewa['detail'] as $d): ?>
            <div style="display:flex;align-items:center;gap:0.8rem;margin-bottom:0.5rem;">
              <div style="width:40px;height:40px;background:var(--cream);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                <?php if (!empty($d['gambar_alat'])): ?>
                  <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($d['gambar_alat']) ?>" alt="<?= htmlspecialchars($d['nama_alat']) ?>" style="width:100%;height:100%;object-fit:cover;"/>
                <?php else: ?>
                  <i class="bi bi-tools" style="color:rgba(26,35,50,0.2);"></i>
                <?php endif; ?>
              </div>
              <div>
                <div style="font-weight:600;font-size:0.88rem;"><?= htmlspecialchars($d['nama_alat']) ?></div>
                <div style="font-size:0.78rem;color:var(--muted);"><?= $d['jumlah'] ?> unit × Rp <?= number_format($d['subtotal'] / $d['jumlah'] / $sewa['lama_sewa'], 0, ',', '.') ?>/hari</div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Info Denda -->
          <?php if ($sewa['denda'] > 0): ?>
          <div style="padding:0.7rem 1.4rem;background:#fef2f2;border-top:1px solid #fecaca;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <div style="font-size:0.8rem;color:#991b1b;">
              <i class="bi bi-exclamation-triangle me-1"></i>
              Denda keterlambatan: <strong>Rp <?= number_format($sewa['denda'], 0, ',', '.') ?></strong>
              <?php if ($sewa['status_denda'] === 'lunas'): ?>
                <span style="background:#d1fae5;color:#065f46;font-size:0.72rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:4px;margin-left:0.4rem;">Lunas</span>
              <?php elseif ($sewa['status_denda'] === 'menunggu'): ?>
                <span style="background:#fef3c7;color:#92400e;font-size:0.72rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:4px;margin-left:0.4rem;">Menunggu Konfirmasi</span>
              <?php endif; ?>
            </div>
            <?php if ($sewa['status_denda'] === 'belum_ditagih'): ?>
            <a href="<?= BASE_URL ?>/pembayaran/formDenda/<?= $sewa['id_penyewaan'] ?>"
               style="background:#dc2626;color:#fff;font-size:0.78rem;font-weight:600;border-radius:7px;padding:0.3rem 0.8rem;text-decoration:none;">
              Bayar Denda
            </a>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <!-- Footer kartu -->
          <div style="padding:0.9rem 1.4rem;background:#fafaf8;border-top:1px solid #f0ece4;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <div style="font-size:0.83rem;color:var(--muted);">
              <i class="bi bi-calendar3 me-1"></i>
              <?= date('d M Y', strtotime($sewa['tanggal_sewa'])) ?> —
              <?= date('d M Y', strtotime($sewa['tanggal_kembali'])) ?>
              <span style="margin-left:0.5rem;">(<?= $sewa['lama_sewa'] ?> hari)</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div style="font-family:'Syne',sans-serif;font-weight:800;color:var(--orange);">
                Rp <?= number_format($sewa['total_harga'], 0, ',', '.') ?>
              </div>
              <a href="<?= BASE_URL ?>/Penyewaan/detail/<?= $sewa['id_penyewaan'] ?>"
                 style="background:var(--steel);color:#fff;font-size:0.8rem;font-weight:600;border-radius:7px;padding:0.35rem 0.9rem;text-decoration:none;transition:background .2s;"
                 onmouseover="this.style.background='var(--orange)'" onmouseout="this.style.background='var(--steel)'">
                Detail
              </a>
              <?php if (($sewa['status_penyewaan'] === 'aktif' || $sewa['status_penyewaan'] === 'selesai') && !empty($sewa['status_bayar']) && $sewa['status_bayar'] === 'lunas'): ?>
              <a href="<?= BASE_URL ?>/surat/download/<?= $sewa['id_penyewaan'] ?>"
                style="background:#d1fae5;color:#065f46;font-size:0.8rem;font-weight:600;
                        border-radius:7px;padding:0.35rem 0.9rem;text-decoration:none;
                        border:1px solid #a7f3d0;">
                <i class="bi bi-file-pdf me-1"></i>PDF
              </a>
              <?php endif; ?>
              <?php if ($sewa['status_penyewaan'] === 'menunggu' && empty($sewa['status_bayar'])): ?>
              <a href="<?= BASE_URL ?>/pembayaran/form/<?= $sewa['id_penyewaan'] ?>"
                 style="background:var(--orange);color:#fff;font-size:0.8rem;font-weight:600;border-radius:7px;padding:0.35rem 0.9rem;text-decoration:none;">
                Bayar
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>