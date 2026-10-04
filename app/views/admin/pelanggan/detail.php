<?php
$panelBase = match($_SESSION['user_role']) { 'pimpinan' => BASE_URL.'/pimpinan', default => BASE_URL.'/admin' };
?>
<div class="row g-3">
  <div class="col-lg-4">
    <!-- INFO PELANGGAN -->
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-person me-2" style="color:var(--orange);"></i>Data Pelanggan</div>
        <a href="<?= $panelBase ?>/pelanggan" class="btn-admin-secondary" style="font-size:0.78rem;padding:0.3rem 0.7rem;"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>
      <div class="content-card-body">
        <div style="text-align:center;margin-bottom:1rem;">
          <div style="width:64px;height:64px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:1.5rem;margin:0 auto 0.6rem;">
            <?= strtoupper(substr($pelanggan['nama_pelanggan'],0,1)) ?>
          </div>
          <div style="font-weight:700;font-size:1.05rem;"><?= htmlspecialchars($pelanggan['nama_pelanggan']) ?></div>
          <div style="font-size:0.8rem;color:var(--muted);"><?= htmlspecialchars($pelanggan['email']) ?></div>
        </div>
        <hr style="border-color:#f0f0f0;"/>
        <div style="font-size:0.85rem;line-height:2.2;">
          <div><i class="bi bi-telephone me-2" style="color:var(--muted);"></i><?= htmlspecialchars($pelanggan['no_hp']) ?></div>
          <div><i class="bi bi-geo-alt me-2" style="color:var(--muted);"></i><?= htmlspecialchars($pelanggan['alamat'] ?? '-') ?></div>
          <div><i class="bi bi-building me-2" style="color:var(--muted);"></i><?= htmlspecialchars($pelanggan['nama_perusahaan'] ?? '-') ?></div>
          <div><i class="bi bi-gender-ambiguous me-2" style="color:var(--muted);"></i><?= htmlspecialchars($pelanggan['jenis_kelamin'] ?? '-') ?></div>
          <div><i class="bi bi-calendar3 me-2" style="color:var(--muted);"></i>Terdaftar <?= date('d M Y', strtotime($pelanggan['created_at'])) ?></div>
        </div>
        <a href="<?= $panelBase ?>/pelangganEdit/<?= $pelanggan['id_pelanggan'] ?>" class="btn-admin-primary mt-3" style="width:100%;justify-content:center;">
          <i class="bi bi-pencil"></i> Edit Data
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <!-- RIWAYAT SEWA -->
    <div class="content-card">
      <div class="content-card-header">
        <div class="content-card-title"><i class="bi bi-clock-history me-2" style="color:var(--orange);"></i>Riwayat Penyewaan</div>
      </div>
      <div style="overflow-x:auto;">
        <table class="table-admin table">
          <thead>
            <tr><th>Kode</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Status Sewa</th><th>Status Bayar</th></tr>
          </thead>
          <tbody>
            <?php if (empty($riwayatSewa)): ?>
            <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem;">Belum ada riwayat penyewaan</td></tr>
            <?php else: ?>
            <?php foreach ($riwayatSewa as $r): ?>
            <tr>
              <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($r['kode_penyewaan']) ?></td>
              <td><?= date('d M Y', strtotime($r['tanggal_sewa'])) ?></td>
              <td><?= date('d M Y', strtotime($r['tanggal_kembali'])) ?></td>
              <td style="font-weight:700;">Rp <?= number_format($r['total_harga'],0,',','.') ?></td>
              <td><span class="badge-status badge-<?= $r['status_penyewaan'] ?>"><?= ucfirst($r['status_penyewaan']) ?></span></td>
              <td>
                <?php if ($r['status_bayar']): ?>
                <span class="badge-status badge-<?= $r['status_bayar'] ?>"><?= ucfirst($r['status_bayar']) ?></span>
                <?php else: ?>
                <span style="color:var(--muted);font-size:0.8rem;">-</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
