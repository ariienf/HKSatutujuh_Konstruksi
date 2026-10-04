<?php $pageTitle = 'Katalog Alat — HK Satu Tujuh'; ?>

<style>
  .filter-card {
    background: #fff;
    border-radius: 12px;
    border: 1.5px solid #e8e3da;
    padding: 1.2rem;
    position: sticky;
    top: 80px;
  }
  .filter-title {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.88rem;
    color: var(--steel);
    margin-bottom: 0.8rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e8e3da;
  }
  .alat-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #e8e3da;
    overflow: hidden;
    transition: all .25s;
    height: 100%;
  }
  .alat-card:hover {
    border-color: var(--orange);
    box-shadow: 0 12px 32px rgba(26,35,50,0.1);
    transform: translateY(-4px);
  }
  .alat-img {
    background: var(--cream);
    height: 275px;
    display: flex; align-items: center; justify-content: center;
    border-bottom: 1px solid #e8e3da;
    position: relative;
    overflow: hidden;
  }
  .alat-img img { width: 100%; height: 100%; object-fit: cover; }
  .badge-tersedia {
    position: absolute; top: 10px; right: 10px;
    background: #d1fae5; color: #065f46;
    font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.55rem; border-radius: 4px;
  }
  .badge-habis {
    position: absolute; top: 10px; right: 10px;
    background: #fee2e2; color: #991b1b;
    font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.55rem; border-radius: 4px;
  }
</style>

<div style="background:#fff;border-bottom:1px solid #e8e3da;padding:1rem 0;">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/" style="color:var(--orange);text-decoration:none;">Beranda</a></li>
        <li class="breadcrumb-item active">Katalog Alat</li>
      </ol>
    </nav>
  </div>
</div>

<section style="padding:2.5rem 0;min-height:70vh;">
  <div class="container">
    <div class="row g-4">

      <!-- SIDEBAR FILTER -->
      <div class="col-lg-3">
        <div class="filter-card">
          <div class="filter-title"><i class="bi bi-funnel me-2"></i>Filter Alat</div>
          <form method="GET" action="<?= BASE_URL ?>/home/katalog">
            <div class="mb-3">
              <label style="font-size:0.82rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Cari Nama Alat</label>
              <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Ketik nama alat..."
                value="<?= htmlspecialchars($keyword) ?>" style="border-radius:7px;border:1.5px solid #e0dbd2;font-size:0.85rem;"/>
            </div>
            <div class="mb-3">
              <label style="font-size:0.82rem;font-weight:600;color:var(--steel);margin-bottom:0.4rem;display:block;">Kategori</label>
              <select name="jenis" class="form-select form-select-sm" style="border-radius:7px;border:1.5px solid #e0dbd2;font-size:0.85rem;">
                <option value="">Semua Kategori</option>
                <?php foreach ($semuaJenis as $j): ?>
                  <option value="<?= htmlspecialchars($j['jenis_alat']) ?>" <?= $jenis === $j['jenis_alat'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($j['jenis_alat']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" style="width:100%;background:var(--orange);color:#fff;border:none;border-radius:7px;padding:0.5rem;font-size:0.85rem;font-weight:600;transition:background .2s;" onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
              <i class="bi bi-search me-1"></i>Cari
            </button>
            <?php if (!empty($keyword) || !empty($jenis)): ?>
            <a href="<?= BASE_URL ?>/home/katalog" style="display:block;text-align:center;margin-top:0.5rem;font-size:0.8rem;color:var(--muted);text-decoration:none;">
              <i class="bi bi-x-circle me-1"></i>Reset filter
            </a>
            <?php endif; ?>
          </form>
        </div>
      </div>

      <!-- DAFTAR ALAT -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <div>
            <h5 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:0.1rem;">
              <?php if (!empty($jenis)): ?>
                <?= htmlspecialchars($jenis) ?>
              <?php elseif (!empty($keyword)): ?>
                Hasil pencarian: "<?= htmlspecialchars($keyword) ?>"
              <?php else: ?>
                Semua Alat
              <?php endif; ?>
            </h5>
            <div style="font-size:0.82rem;color:var(--muted);"><?= count($daftarAlat) ?> alat ditemukan</div>
          </div>
        </div>

        <?php if (empty($daftarAlat)): ?>
          <div class="text-center py-5" style="background:#fff;border-radius:14px;border:1.5px solid #e8e3da;">
            <i class="bi bi-search" style="font-size:3rem;color:#ddd;"></i>
            <p class="mt-3 text-muted">Tidak ada alat yang ditemukan.</p>
            <a href="<?= BASE_URL ?>/home/katalog" style="color:var(--orange);font-weight:600;text-decoration:none;">Reset pencarian</a>
          </div>
        <?php else: ?>
          <div class="row g-3">
            <?php foreach ($daftarAlat as $alat): ?>
            <div class="col-md-6 col-xl-4">
              <div class="alat-card">
                <div class="alat-img">
                  <?php if (!empty($alat['gambar_alat'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/alat/<?= htmlspecialchars($alat['gambar_alat']) ?>" alt="<?= htmlspecialchars($alat['nama_alat']) ?>"/>
                  <?php else: ?>
                    <i class="bi bi-tools" style="font-size:3.5rem;color:rgba(26,35,50,0.12);"></i>
                  <?php endif; ?>
                  <?php if ($alat['status_alat'] === 'tersedia'): ?>
                    <span class="badge-tersedia"><i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i>Tersedia</span>
                  <?php else: ?>
                    <span class="badge-habis"><i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i>Habis</span>
                  <?php endif; ?>
                </div>
                <div style="padding:1rem;">
                  <div style="font-size:0.68rem;font-weight:700;color:var(--orange);letter-spacing:1px;text-transform:uppercase;margin-bottom:0.25rem;">
                    <?= htmlspecialchars($alat['jenis_alat']) ?>
                  </div>
                  <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;margin-bottom:0.35rem;">
                    <?= htmlspecialchars($alat['nama_alat']) ?>
                  </div>
                  <div style="font-size:0.8rem;color:var(--muted);line-height:1.5;margin-bottom:0.8rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?= htmlspecialchars($alat['deskripsi']) ?>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                      <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem;color:var(--orange);">
                        Rp <?= number_format($alat['biaya_sewa'], 0, ',', '.') ?>
                        <span style="font-family:'DM Sans',sans-serif;font-weight:400;font-size:0.7rem;color:var(--muted);">/ hari</span>
                      </div>
                      <div style="font-size:0.7rem;color:var(--muted);">Min. <?= $alat['minimum_sewa'] ?> hari</div>
                    </div>
                    <div style="font-size:0.75rem;color:var(--muted);">
                      <i class="bi bi-box-seam me-1"></i><?= $alat['stok'] ?>
                    </div>
                  </div>
                  <?php if ($alat['status_alat'] === 'tersedia'): ?>
                    <a href="<?= BASE_URL ?>/home/detail/<?= $alat['id_alat'] ?>"
                       style="display:block;background:var(--steel);color:#fff;font-weight:600;font-size:0.83rem;border-radius:7px;padding:0.5rem 1rem;text-align:center;text-decoration:none;transition:background .2s;"
                       onmouseover="this.style.background='var(--orange)'" onmouseout="this.style.background='var(--steel)'">
                      <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                  <?php else: ?>
                    <button disabled style="display:block;width:100%;background:#f3f4f6;color:#9ca3af;font-size:0.83rem;border:none;border-radius:7px;padding:0.5rem;cursor:not-allowed;">
                      <i class="bi bi-clock me-1"></i>Stok Habis
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
