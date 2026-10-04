<?php $panelBase = BASE_URL . '/penjualan'; ?>

<!-- BELUM DIKEMBALIKAN -->
<?php if (!empty($belumKembali)): ?>
<div class="content-card mb-4">
  <div class="content-card-header">
    <div class="content-card-title">
      <i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>
      Belum Dikembalikan (<?= count($belumKembali) ?>)
    </div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode Sewa</th><th>Pelanggan</th><th>No. HP</th><th>Jadwal Kembali</th><th>Keterlambatan</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($belumKembali as $b): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($b['kode_penyewaan']) ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($b['nama_pelanggan']) ?></td>
          <td><?= htmlspecialchars($b['no_hp']) ?></td>
          <td style="<?= $b['hari_terlambat'] > 0?'color:#ef4444;font-weight:700;':'' ?>">
            <?= date('d M Y', strtotime($b['tanggal_kembali'])) ?>
          </td>
          <td>
            <?php if ($b['hari_terlambat'] > 0): ?>
              <span style="background:#fee2e2;color:#991b1b;font-size:0.75rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;">
                <?= $b['hari_terlambat'] ?> hari
              </span>
            <?php elseif ($b['hari_terlambat'] == 0): ?>
              <span style="background:#fef3c7;color:#92400e;font-size:0.75rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;">
                Hari ini
              </span>
            <?php else: ?>
              <span style="background:#d1fae5;color:#065f46;font-size:0.75rem;padding:0.2rem 0.5rem;border-radius:4px;">
                Belum jatuh tempo
              </span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?= $panelBase ?>/pengembalianProses/<?= $b['id_penyewaan'] ?>"
               class="btn-admin-primary" style="font-size:0.78rem;padding:0.3rem 0.8rem;">
              <i class="bi bi-box-arrow-in-left"></i> Proses
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<!-- RIWAYAT PENGEMBALIAN -->
<div class="content-card">
  <div class="content-card-header">
    <div class="content-card-title"><i class="bi bi-box-arrow-in-left me-2" style="color:var(--orange);"></i>Riwayat Pengembalian</div>
  </div>
  <div style="overflow-x:auto;">
    <table class="table-admin table">
      <thead>
        <tr><th>Kode Sewa</th><th>Pelanggan</th><th>Jadwal Kembali</th><th>Tgl Dikembalikan</th><th>Status</th><th>Denda</th><th>Keterangan</th></tr>
      </thead>
      <tbody>
        <?php if (empty($daftarKembali)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:2rem;">Belum ada data pengembalian</td></tr>
        <?php else: ?>
        <?php foreach ($daftarKembali as $k): ?>
        <tr>
          <td style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;"><?= htmlspecialchars($k['kode_penyewaan']) ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($k['nama_pelanggan']) ?></td>
          <td><?= date('d M Y', strtotime($k['tanggal_kembali'])) ?></td>
          <td><?= date('d M Y', strtotime($k['tanggal_pengembalian'])) ?></td>
          <td>
            <span style="font-size:0.75rem;font-weight:700;padding:0.25rem 0.6rem;border-radius:4px;
                         background:<?= $k['status_pengembalian']==='tepat_waktu'?'#d1fae5':'#fee2e2' ?>;
                         color:<?= $k['status_pengembalian']==='tepat_waktu'?'#065f46':'#991b1b' ?>;">
              <?= ucfirst(str_replace('_',' ',$k['status_pengembalian'])) ?>
            </span>
          </td>
          <td style="font-weight:700;color:<?= $k['denda']>0?'#dc2626':'var(--muted)' ?>;">
            <?= $k['denda']>0 ? 'Rp '.number_format($k['denda'],0,',','.') : '-' ?>
          </td>
          <td style="font-size:0.82rem;color:var(--muted);"><?= htmlspecialchars($k['keterangan']??'-') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
