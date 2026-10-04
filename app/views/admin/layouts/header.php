<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $pageTitle ?? 'Admin Panel' ?> — HKSATUTUJUH</title>
  <link rel="icon" type="image/jpeg" href="<?= BASE_URL ?>/public/images/logo.jpeg"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --orange: #E05A1E;
      --orange-dark: #B84212;
      --steel: #1A2332;
      --steel-mid: #2D3F55;
      --cream: #F7F4EF;
      --muted: #8A8F99;
      --sidebar-w: 260px;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #F0F2F5;
      color: var(--steel);
    }
    h1,h2,h3,h4,h5,h6 { font-family: 'Syne', sans-serif; }

    /* ── SIDEBAR ── */
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--steel);
      border-right: 2px solid var(--orange);
      display: flex;
      flex-direction: column;
      z-index: 1000;
      overflow-y: auto;
      transition: transform .3s;
    }
    .sidebar-brand {
      padding: 1.2rem 1.3rem;
      border-bottom: 1px solid rgba(255,255,255,0.07);
      flex-shrink: 0;
    }
    .brand-text {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 1rem;
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.55rem;
      white-space: nowrap;
    }
    .brand-text span { color: var(--orange); }
    .brand-text img {
      height: 32px;
      width: 32px;
      object-fit: cover;
      border-radius: 7px;
      flex-shrink: 0;
    }
    .brand-role {
      font-size: 0.72rem;
      color: rgba(255,255,255,0.4);
      margin-top: 0.2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .sidebar-nav { padding: 1rem 0; flex: 1; }
    .nav-section {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.3);
      padding: 0.8rem 1.5rem 0.4rem;
    }
    .nav-item-admin {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      padding: 0.6rem 1.5rem;
      color: rgba(255,255,255,0.65);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: all .2s;
    }
    .nav-item-admin:hover {
      color: #fff;
      background: rgba(255,255,255,0.05);
      border-left-color: rgba(224,90,30,0.4);
    }
    .nav-item-admin.active {
      color: #fff;
      background: rgba(224,90,30,0.12);
      border-left-color: var(--orange);
    }
    .nav-item-admin i { font-size: 1rem; width: 20px; text-align: center; }
    .sidebar-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255,255,255,0.07);
      flex-shrink: 0;
    }
    .user-info {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      margin-bottom: 0.8rem;
    }
    .user-avatar {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: var(--orange);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      color: #fff;
      font-size: 0.85rem;
      flex-shrink: 0;
    }
    .user-name { font-size: 0.85rem; font-weight: 600; color: #fff; }
    .user-role { font-size: 0.72rem; color: rgba(255,255,255,0.4); }
    .btn-logout {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      width: 100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      color: rgba(255,255,255,0.6);
      border-radius: 8px;
      padding: 0.45rem 0.9rem;
      font-size: 0.82rem;
      text-decoration: none;
      transition: all .2s;
    }
    .btn-logout:hover { background: rgba(220,38,38,0.15); border-color: rgba(220,38,38,0.3); color: #fca5a5; }

    /* ── TOPBAR ── */
    .topbar {
      position: fixed;
      top: 0;
      left: var(--sidebar-w);
      right: 0;
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.5rem;
      z-index: 999;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .topbar-left { display: flex; align-items: center; gap: 0.8rem; }
    .btn-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.3rem;
      color: var(--steel);
      cursor: pointer;
    }
    .topbar-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 1rem;
      color: var(--steel);
    }
    .topbar-right { display: flex; align-items: center; gap: 1rem; }

    /* ── MAIN CONTENT ── */
    .main-content {
      margin-left: var(--sidebar-w);
      margin-top: 60px;
      padding: 1.8rem;
      min-height: calc(100vh - 60px);
    }

    /* ── CARDS ── */
    .stat-card {
      background: #fff;
      border-radius: 14px;
      padding: 1.3rem 1.2rem;
      border: 1px solid #e5e7eb;
      height: 100%;
      overflow: hidden;
    }
    .stat-icon {
      width: 48px; height: 48px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
      margin-bottom: 0.9rem;
    }
    .stat-num {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      line-height: 1.2;
      margin-bottom: 0.3rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .stat-label { font-size: 0.82rem; color: var(--muted); }
    .content-card {
      background: #fff;
      border-radius: 14px;
      border: 1px solid #e5e7eb;
      overflow: hidden;
    }
    .content-card-header {
      padding: 1rem 1.4rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .content-card-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      color: var(--steel);
    }
    .content-card-body { padding: 1.2rem 1.4rem; }

    /* ── TABLE ── */
    .table-admin { font-size: 0.85rem; margin: 0; }
    .table-admin thead th {
      background: #f9fafb;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--muted);
      border-bottom: 1px solid #e5e7eb;
      padding: 0.75rem 1rem;
      white-space: nowrap;
    }
    .table-admin tbody td {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #f3f4f6;
      vertical-align: middle;
    }
    .table-admin tbody tr:last-child td { border-bottom: none; }
    .table-admin tbody tr:hover { background: #fafafa; }

    /* ── BADGE STATUS ── */
    .badge-status {
      font-size: 0.7rem;
      font-weight: 700;
      padding: 0.25rem 0.6rem;
      border-radius: 4px;
    }
    .badge-menunggu   { background: #fef3c7; color: #92400e; }
    .badge-diproses   { background: #dbeafe; color: #1e40af; }
    .badge-aktif      { background: #d1fae5; color: #065f46; }
    .badge-selesai    { background: #f3f4f6; color: #374151; }
    .badge-dibatalkan { background: #fee2e2; color: #991b1b; }
    .badge-lunas      { background: #d1fae5; color: #065f46; }
    .badge-gagal      { background: #fee2e2; color: #991b1b; }
    .badge-tersedia   { background: #d1fae5; color: #065f46; }
    .badge-habis      { background: #fee2e2; color: #991b1b; }
    .badge-maintenance{ background: #fef3c7; color: #92400e; }

    /* ── BUTTONS ── */
    .btn-admin-primary {
      background: var(--orange);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 0.45rem 1rem;
      font-size: 0.83rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: background .2s;
      cursor: pointer;
    }
    .btn-admin-primary:hover { background: var(--orange-dark); color: #fff; }
    .btn-admin-secondary {
      background: #f3f4f6;
      color: var(--steel);
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 0.45rem 1rem;
      font-size: 0.83rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: all .2s;
      cursor: pointer;
    }
    .btn-admin-secondary:hover { background: #e5e7eb; color: var(--steel); }
    .btn-admin-danger {
      background: #fee2e2;
      color: #991b1b;
      border: none;
      border-radius: 8px;
      padding: 0.45rem 1rem;
      font-size: 0.83rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: background .2s;
      cursor: pointer;
    }
    .btn-admin-danger:hover { background: #fecaca; color: #991b1b; }
    .btn-sm-icon {
      width: 30px; height: 30px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all .2s;
    }

    /* ── FORM ── */
    .form-label-admin { font-size: 0.85rem; font-weight: 600; color: var(--steel); margin-bottom: 0.4rem; }
    .form-control-admin {
      border-radius: 8px;
      border: 1.5px solid #e0dbd2;
      padding: 0.6rem 0.9rem;
      font-size: 0.88rem;
      width: 100%;
      transition: border-color .2s;
    }
    .form-control-admin:focus {
      outline: none;
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,90,30,0.08);
    }

    /* ── FLASH ── */
    .flash-admin {
      border-radius: 10px;
      padding: 0.8rem 1rem;
      font-size: 0.85rem;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .flash-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .flash-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* ── RESPONSIVE ── */
    @media (max-width: 992px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .topbar { left: 0; }
      .main-content { margin-left: 0; }
      .btn-toggle { display: block; }
    }
  </style>
</head>
<body>

<?php
// Tentukan role label
$roleLabel = [
  'administrator' => 'Administrator',
  'pimpinan'      => 'Pimpinan',
  'bagian_penjualan' => 'Bagian Penjualan',
];
$currentRole = $_SESSION['user_role'] ?? '';
$roleName    = $roleLabel[$currentRole] ?? 'Staff';

// Tentukan base URL panel
$panelBase = match($currentRole) {
  'administrator'    => BASE_URL . '/admin',
  'pimpinan'         => BASE_URL . '/pimpinan',
  'bagian_penjualan' => BASE_URL . '/penjualan',
  default            => BASE_URL . '/admin',
};

// Menu navigasi berdasarkan role
$navMenus = [];

if (in_array($currentRole, ['administrator', 'pimpinan'])) {
  $navMenus = [
    'MENU UTAMA' => [
      ['icon' => 'speedometer2',  'label' => 'Dashboard',    'url' => $panelBase . '/dashboard'],
    ],
    'MASTER DATA' => [
      ['icon' => 'tools',         'label' => 'Alat Konstruksi', 'url' => $panelBase . '/alat'],
      ['icon' => 'people',        'label' => 'Pelanggan',    'url' => $panelBase . '/pelanggan'],
    ],
    'TRANSAKSI' => [
      ['icon' => 'file-text',     'label' => 'Penyewaan',    'url' => $panelBase . '/Penyewaan'],
      ['icon' => 'credit-card',   'label' => 'Pembayaran',   'url' => $panelBase . '/pembayaran'],
      ['icon' => 'box-arrow-in-left', 'label' => 'Pengembalian', 'url' => $panelBase . '/pengembalian'],
    ],
    'LAPORAN' => [
      ['icon' => 'bar-chart-line', 'label' => 'Laporan',     'url' => $panelBase . '/laporan'],
    ],
  ];
} elseif ($currentRole === 'bagian_penjualan') {
  $navMenus = [
    'MENU UTAMA' => [
      ['icon' => 'speedometer2',  'label' => 'Dashboard',    'url' => $panelBase . '/dashboard'],
    ],
    'TRANSAKSI' => [
      ['icon' => 'file-text',     'label' => 'Penyewaan',    'url' => $panelBase . '/Penyewaan'],
      ['icon' => 'credit-card',   'label' => 'Pembayaran',   'url' => $panelBase . '/pembayaran'],
      ['icon' => 'box-arrow-in-left', 'label' => 'Pengembalian', 'url' => $panelBase . '/pengembalian'],
    ],
    'LAPORAN' => [
      ['icon' => 'bar-chart-line', 'label' => 'Laporan',     'url' => $panelBase . '/laporan'],
    ],
  ];
}

// Deteksi URL aktif
$currentUri = $_SERVER['REQUEST_URI'];
?>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <a href="<?= $panelBase ?>/dashboard" class="brand-text">
      <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
      HKSATUTUJUH
    </a>
    <div class="brand-role"><?= $roleName ?> Panel</div>
  </div>

  <nav class="sidebar-nav">
    <?php foreach ($navMenus as $section => $items): ?>
      <div class="nav-section"><?= $section ?></div>
      <?php foreach ($items as $item): ?>
        <a href="<?= $item['url'] ?>"
           class="nav-item-admin <?= strpos($currentUri, $item['url']) !== false ? 'active' : '' ?>">
          <i class="bi bi-<?= $item['icon'] ?>"></i>
          <?= $item['label'] ?>
        </a>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </nav>

  <div class="sidebar-footer">
    <div class="user-info">
      <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_nama'] ?? 'A', 0, 1)) ?></div>
      <div>
        <div class="user-name"><?= htmlspecialchars($_SESSION['user_nama'] ?? '') ?></div>
        <div class="user-role"><?= $roleName ?></div>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/auth/logout" class="btn-logout">
      <i class="bi bi-box-arrow-right"></i> Keluar
    </a>
  </div>
</aside>

<!-- TOPBAR -->
<header class="topbar">
  <div class="topbar-left">
    <button class="btn-toggle" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
    <div class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></div>
  </div>
  <div class="topbar-right">
    <a href="<?= BASE_URL ?>/" target="_blank"
       style="font-size:0.82rem;color:var(--muted);text-decoration:none;">
      <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Website
    </a>
    <div style="width:1px;height:20px;background:#e5e7eb;"></div>
    <div style="font-size:0.82rem;color:var(--muted);"><?= date('d M Y') ?></div>
  </div>
</header>

<!-- OVERLAY untuk mobile -->
<div id="sidebarOverlay" onclick="toggleSidebar()"
  style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;"></div>

<!-- MAIN CONTENT -->
<main class="main-content">

<?php
// Flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
if ($flash):
?>
<div class="flash-admin flash-<?= $flash['type'] === 'error' ? 'error' : 'success' ?>">
  <i class="bi bi-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
  <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>