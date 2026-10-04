<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Staff — HK Satu Tujuh</title>
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
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      padding: 1rem;
      background:
        linear-gradient(rgba(26,35,50,0.55), rgba(26,35,50,0.75)),
        url('<?= BASE_URL ?>/public/images/auth-bg.jpg') center/cover no-repeat fixed;
    }
    /* Background dekorasi */
    body::before {
      content: '';
      position: absolute;
      top: -150px; right: -150px;
      width: 500px; height: 500px;
      border-radius: 50%;
      background: var(--orange);
      opacity: 0.05;
    }
    body::after {
      content: '';
      position: absolute;
      bottom: -100px; left: -100px;
      width: 350px; height: 350px;
      border-radius: 50%;
      background: var(--orange);
      opacity: 0.04;
    }
    .login-wrapper {
      display: flex;
      width: 100%;
      max-width: 900px;
      min-height: 520px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 24px 60px rgba(0,0,0,0.4);
      position: relative;
      z-index: 1;
      margin: 1rem;
    }
    /* Panel kiri */
    .login-left {
      flex: 1;
      background: var(--orange);
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }
    .login-left::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(255,255,255,0.08);
    }
    .login-left::after {
      content: '';
      position: absolute;
      bottom: -40px; left: -40px;
      width: 160px; height: 160px;
      border-radius: 50%;
      background: rgba(255,255,255,0.06);
    }
    .left-brand {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: #fff;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .left-brand span { opacity: 0.7; }
    .left-brand img {
      height: 40px;
      width: 40px;
      object-fit: cover;
      border-radius: 8px;
    }
    .left-content { position: relative; z-index: 1; }
    .left-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.8rem;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 1rem;
    }
    .left-desc {
      color: rgba(255,255,255,0.75);
      font-size: 0.9rem;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }
    .role-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 8px;
      padding: 0.5rem 0.9rem;
      color: #fff;
      font-size: 0.82rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      width: fit-content;
    }
    .left-footer {
      color: rgba(255,255,255,0.5);
      font-size: 0.78rem;
      position: relative;
      z-index: 1;
    }

    /* Panel kanan */
    .login-right {
      flex: 1;
      background: #fff;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .login-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: var(--steel);
      margin-bottom: 0.3rem;
    }
    .login-subtitle {
      color: #9ca3af;
      font-size: 0.85rem;
      margin-bottom: 2rem;
    }
    .form-group { margin-bottom: 1.2rem; }
    .form-label-login {
      font-size: 0.83rem;
      font-weight: 700;
      color: var(--steel);
      display: block;
      margin-bottom: 0.4rem;
    }
    .form-input {
      width: 100%;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      padding: 0.7rem 1rem;
      font-size: 0.9rem;
      font-family: 'DM Sans', sans-serif;
      color: var(--steel);
      transition: all .2s;
      outline: none;
    }
    .form-input:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,90,30,0.08);
    }
    .input-wrapper { position: relative; }
    .input-icon {
      position: absolute;
      left: 0.9rem;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 1rem;
    }
    .form-input.with-icon { padding-left: 2.5rem; }
    .eye-toggle {
      position: absolute;
      right: 0.9rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #9ca3af;
      cursor: pointer;
      padding: 0;
      font-size: 1rem;
    }
    .btn-login-submit {
      width: 100%;
      background: var(--steel);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 0.8rem;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all .2s;
      margin-top: 0.5rem;
    }
    .btn-login-submit:hover {
      background: var(--orange);
      transform: translateY(-1px);
    }
    .alert-error {
      background: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
      border-radius: 8px;
      padding: 0.7rem 1rem;
      font-size: 0.83rem;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.82rem;
      color: #9ca3af;
      text-decoration: none;
      transition: color .2s;
    }
    .back-link:hover { color: var(--orange); }

    @media (max-width: 640px) {
      .login-left { display: none; }
      .login-right { padding: 2rem 1.5rem; }
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <!-- PANEL KIRI -->
  <div class="login-left">
    <div class="left-brand">
      <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh"/>
      HK Satu<span>Tujuh</span>
    </div>
    <div class="left-content">
      <h2 class="left-title">Panel Manajemen Sistem</h2>
      <p class="left-desc">Akses khusus untuk tim internal. Kelola data penyewaan, pembayaran, dan laporan dalam satu panel terpusat.</p>
      <!-- <div class="d-flex flex-column gap-2">
        <div class="role-badge"><i class="bi bi-shield-check"></i> Administrator</div>
        <div class="role-badge"><i class="bi bi-person-badge"></i> Pimpinan</div>
        <div class="role-badge"><i class="bi bi-bag-check"></i> Bagian Penjualan</div>
      </div> -->
    </div>
    <div class="left-footer">© <?= date('Y') ?> HK Satu Tujuh. Internal use only.</div>
  </div>

  <!-- PANEL KANAN -->
  <div class="login-right">
    <h3 class="login-title">Selamat Datang</h3>
    <p class="login-subtitle">Masuk dengan akun staff Anda</p>

    <!-- Flash error -->
    <?php if (!empty($flash) && $flash['type'] === 'error'): ?>
    <div class="alert-error">
      <i class="bi bi-exclamation-circle"></i>
      <?= htmlspecialchars($flash['message']) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/backendLogin">
      <div class="form-group">
        <label class="form-label-login">Username</label>
        <div class="input-wrapper">
          <i class="bi bi-person input-icon"></i>
          <input type="text" name="username" class="form-input with-icon"
            placeholder="Masukkan username" required autofocus
            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"/>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label-login">Password</label>
        <div class="input-wrapper">
          <i class="bi bi-lock input-icon"></i>
          <input type="password" name="password" id="passwordInput" class="form-input with-icon"
            placeholder="Masukkan password" required style="padding-right:2.8rem;"/>
          <button type="button" class="eye-toggle" onclick="togglePassword()">
            <i class="bi bi-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <label style="display:flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:#6b7280;cursor:pointer;">
          <input type="checkbox" name="ingat" style="accent-color:var(--orange);"/>
          Ingat saya
        </label>
      </div>

      <button type="submit" class="btn-login-submit">
        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Panel
      </button>
    </form>

    <a href="<?= BASE_URL ?>/" class="back-link">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman utama
    </a>
  </div>
</div>

<script>
function togglePassword() {
  const input = document.getElementById('passwordInput');
  const icon  = document.getElementById('eyeIcon');
  input.type  = input.type === 'password' ? 'text' : 'password';
  icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>