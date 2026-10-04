<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $pageTitle ?? 'HKSATUTUJUH' ?></title>
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
    }
    * { box-sizing: border-box; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--steel);
    }
    h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

    /* NAVBAR */
    .navbar-custom {
      background: var(--steel);
      padding: 0.85rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 2px solid var(--orange);
    }
    .brand-logo {
      font-family: 'Syne', sans-serif;
      font-size: 1.4rem;
      font-weight: 800;
      color: #fff;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
    }
    .brand-logo span { color: var(--orange); }
    .brand-logo img {
      height: 40px;
      width: 40px;
      object-fit: cover;
      border-radius: 8px;
    }
    .nav-link-custom {
      color: rgba(255,255,255,0.7) !important;
      font-weight: 500;
      font-size: 0.88rem;
      padding: 0.4rem 0.8rem !important;
      border-radius: 6px;
      transition: all .2s;
    }
    .nav-link-custom:hover,
    .nav-link-custom.active {
      color: #fff !important;
      background: rgba(255,255,255,0.07);
    }
    .btn-nav-login {
      background: transparent;
      border: 1.5px solid rgba(255,255,255,0.35);
      color: #fff;
      font-size: 0.83rem;
      font-weight: 500;
      border-radius: 7px;
      padding: 0.35rem 1rem;
      transition: all .2s;
      text-decoration: none;
    }
    .btn-nav-login:hover { border-color: var(--orange); color: var(--orange); }
    .btn-nav-daftar {
      background: var(--orange);
      border: none;
      color: #fff;
      font-size: 0.83rem;
      font-weight: 700;
      border-radius: 7px;
      padding: 0.35rem 1.1rem;
      transition: all .2s;
      text-decoration: none;
    }
    .btn-nav-daftar:hover { background: var(--orange-dark); color: #fff; }
    .dropdown-menu {
      border: 1px solid #e8e3da;
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 0.5rem;
    }
    .dropdown-item {
      border-radius: 6px;
      font-size: 0.85rem;
      padding: 0.45rem 0.8rem;
    }
    .dropdown-item:hover { background: rgba(224,90,30,0.08); color: var(--orange); }

    /* FLASH MESSAGE GLOBAL */
    .flash-global {
      position: fixed;
      top: 70px;
      right: 20px;
      z-index: 9999;
      min-width: 300px;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-custom navbar-expand-lg">
  <div class="container">
    <a href="<?= BASE_URL ?>/" class="brand-logo me-4">
      <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
      HKSATU<span>TUJUH</span>
    </a>
    <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <i class="bi bi-list text-white fs-4"></i>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto gap-1 mt-2 mt-lg-0">
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/" class="nav-link nav-link-custom <?= (strpos($_SERVER['REQUEST_URI'], '/home') !== false || $_SERVER['REQUEST_URI'] === '/' . basename(BASE_URL) . '/') ? 'active' : '' ?>">
            <i class="bi bi-house me-1"></i>Beranda
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/home/katalog" class="nav-link nav-link-custom <?= strpos($_SERVER['REQUEST_URI'], '/katalog') !== false ? 'active' : '' ?>">
            <i class="bi bi-grid me-1"></i>Katalog Alat
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/home/caraSewa" class="nav-link nav-link-custom <?= strpos($_SERVER['REQUEST_URI'], '/caraSewa') !== false ? 'active' : '' ?>">
            <i class="bi bi-info-circle me-1"></i>Cara Sewa
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/home/tentangKami" class="nav-link nav-link-custom <?= strpos($_SERVER['REQUEST_URI'], '/tentangKami') !== false ? 'active' : '' ?>">
            <i class="bi bi-people me-1"></i>Tentang Kami
          </a>
        </li>
      </ul>

      <!-- Jika belum login -->
      <?php if (empty($_SESSION['user_role'])): ?>
      <div class="d-flex gap-2 mt-2 mt-lg-0">
        <a href="<?= BASE_URL ?>/auth/login" class="btn-nav-login">
          <i class="bi bi-person me-1"></i>Masuk
        </a>
        <a href="<?= BASE_URL ?>/auth/register" class="btn-nav-daftar">
          Daftar Gratis
        </a>
      </div>

      <!-- Jika sudah login sebagai pelanggan -->
      <?php elseif ($_SESSION['user_role'] === 'pelanggan'): ?>
      <div class="dropdown mt-2 mt-lg-0">
        <button class="btn-nav-login dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
          <div style="width:28px;height:28px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;">
            <?= strtoupper(substr($_SESSION['user_nama'], 0, 1)) ?>
          </div>
          <span style="font-size:0.85rem;"><?= htmlspecialchars($_SESSION['user_nama']) ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="<?= BASE_URL ?>/pelanggan/profil"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
          <li><a class="dropdown-item" href="<?= BASE_URL ?>/Penyewaan/riwayat"><i class="bi bi-clock-history me-2"></i>Riwayat Sewa</a></li>
          <li><hr class="dropdown-divider my-1"></li>
          <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
        </ul>
      </div>

      <!-- Jika sudah login sebagai staff -->
      <?php else: ?>
      <div class="dropdown mt-2 mt-lg-0">
        <button class="btn-nav-login dropdown-toggle" data-bs-toggle="dropdown">
          <i class="bi bi-person-badge me-1"></i>
          <?= htmlspecialchars($_SESSION['user_nama']) ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <span class="dropdown-item-text text-muted" style="font-size:0.75rem;">
              <?= ucfirst(str_replace('_', ' ', $_SESSION['user_role'])) ?>
            </span>
          </li>
          <li><hr class="dropdown-divider my-1"></li>
          <li><a class="dropdown-item" href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'administrator' ? 'admin' : ($_SESSION['user_role'] === 'pimpinan' ? 'pimpinan' : 'penjualan') ?>/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
          <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
        </ul>
      </div>
      <?php endif; ?>

    </div>
  </div>
</nav>

<!-- Flash message global -->
<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
if ($flash):
?>
<div class="flash-global">
  <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info') ?> alert-dismissible fade show shadow" style="font-size:0.85rem;border-radius:10px;">
    <i class="bi bi-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?> me-2"></i>
    <?= htmlspecialchars($flash['message']) ?>
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
  </div>
</div>
<?php endif; ?>
