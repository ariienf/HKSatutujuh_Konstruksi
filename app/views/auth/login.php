<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk — HK Satu Tujuh</title>
  <link rel="icon" type="image/jpeg" href="<?= BASE_URL ?>/public/images/logo.jpeg"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --orange: #E05A1E;
      --steel: #1A2332;
      --cream: #F7F4EF;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background:
        linear-gradient(rgba(26,35,50,0.45), rgba(26,35,50,0.65)),
        url('<?= BASE_URL ?>/public/images/auth-bg.jpg') center/cover no-repeat fixed;
    }
    .auth-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.35);
      overflow: hidden;
      width: 100%;
      max-width: 440px;
    }
    .auth-header {
      background: var(--steel);
      padding: 2rem;
      text-align: center;
      border-bottom: 3px solid var(--orange);
    }
    .auth-logo {
      height: 64px;
      width: 64px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 0.8rem;
    }
    .auth-brand {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: #fff;
    }
    .auth-brand span { color: var(--orange); }
    .auth-subtitle { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 0.3rem; }
    .auth-body { padding: 2rem; }
    .form-label { font-weight: 600; font-size: 0.88rem; color: var(--steel); }
    .form-control {
      border-radius: 8px;
      border: 1.5px solid #e0dbd2;
      padding: 0.65rem 1rem;
      font-size: 0.92rem;
      transition: border-color .2s;
    }
    .form-control:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,90,30,0.1);
    }
    .btn-masuk {
      background: var(--orange);
      color: #fff;
      font-weight: 700;
      font-family: 'Syne', sans-serif;
      border: none;
      border-radius: 8px;
      padding: 0.75rem;
      width: 100%;
      font-size: 0.95rem;
      transition: background .2s;
    }
    .btn-masuk:hover { background: #b84212; }
    .auth-footer {
      text-align: center;
      padding: 1rem 2rem 1.5rem;
      font-size: 0.85rem;
      color: #888;
    }
    .auth-footer a { color: var(--orange); font-weight: 600; text-decoration: none; }
    .input-group-text {
      border-radius: 0 8px 8px 0 !important;
      border: 1.5px solid #e0dbd2;
      border-left: none;
      background: #f9f7f4;
      cursor: pointer;
    }
    .input-group .form-control { border-radius: 8px 0 0 8px !important; }
  </style>
</head>
<body>
<div class="auth-card">
  <div class="auth-header">
    <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh" class="auth-logo"/>
    <div class="auth-brand">HKSatu<span>Tujuh</span></div>
    <div class="auth-subtitle">Masuk ke akun Anda</div>
  </div>
  <div class="auth-body">

    <!-- Flash Message -->
    <?php if (!empty($flash)): ?>
      <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show rounded-3 py-2 px-3 mb-3" style="font-size:0.85rem;">
        <i class="bi bi-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/login">
      <div class="mb-3">
        <label class="form-label">Email / Username</label>
        <input type="text" name="username" class="form-control" placeholder="Email atau username" required autofocus/>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <input type="password" name="password" class="form-control" placeholder="••••••••" id="passwordInput" required/>
          <span class="input-group-text" onclick="togglePassword()">
            <i class="bi bi-eye" id="eyeIcon"></i>
          </span>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="ingat"/>
          <label class="form-check-label" for="ingat" style="font-size:0.83rem;">Ingat saya</label>
        </div>
        <a href="#" style="font-size:0.83rem;color:var(--orange);text-decoration:none;">Lupa password?</a>
      </div>
      <button type="submit" class="btn-masuk">
        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
      </button>
    </form>
  </div>
  <div class="auth-footer">
    Belum punya akun? <a href="<?= BASE_URL ?>/auth/register">Daftar sekarang</a>
  </div>
  <div class="auth-footer">
    <a href="<?= BASE_URL ?>/" class="back-link">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman utama
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'bi bi-eye';
    }
  }
</script>
</body>
</html>
