<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar — HK Satu Tujuh</title>
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
      padding: 2rem 1rem;
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
      max-width: 560px;
    }
    .auth-header {
      background: var(--steel);
      padding: 1.8rem 2rem;
      text-align: center;
      border-bottom: 3px solid var(--orange);
    }
    .auth-logo {
      height: 56px;
      width: 56px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 0.7rem;
    }
    .auth-brand {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: #fff;
    }
    .auth-brand span { color: var(--orange); }
    .auth-subtitle { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 0.3rem; }
    .auth-body { padding: 2rem; }
    .form-label { font-weight: 600; font-size: 0.88rem; color: var(--steel); }
    .form-control, .form-select {
      border-radius: 8px;
      border: 1.5px solid #e0dbd2;
      padding: 0.65rem 1rem;
      font-size: 0.92rem;
      transition: border-color .2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,90,30,0.1);
    }
    .btn-daftar {
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
    .btn-daftar:hover { background: #b84212; }
    .auth-footer {
      text-align: center;
      padding: 1rem 2rem 1.5rem;
      font-size: 0.85rem;
      color: #888;
    }
    .auth-footer a { color: var(--orange); font-weight: 600; text-decoration: none; }
    .section-divider {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.78rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--orange);
      border-bottom: 1px solid #e0dbd2;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
      margin-top: 1.2rem;
    }
    .input-group-text {
      border-radius: 0 8px 8px 0 !important;
      border: 1.5px solid #e0dbd2;
      border-left: none;
      background: #f9f7f4;
      cursor: pointer;
    }
    .input-group .form-control { border-radius: 8px 0 0 8px !important; }
    .password-strength { height: 4px; border-radius: 2px; margin-top: 6px; transition: all .3s; }
  </style>
</head>
<body>
<div class="auth-card">
  <div class="auth-header">
    <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh" class="auth-logo"/>
    <div class="auth-brand">HKSatu<span>Tujuh</span></div>
    <div class="auth-subtitle">Buat akun pelanggan baru</div>
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

    <form method="POST" action="<?= BASE_URL ?>/auth/register" enctype="multipart/form-data">

      <!-- DATA DIRI -->
      <div class="section-divider"><i class="bi bi-person me-1"></i> Data Diri</div>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_pelanggan" class="form-control" placeholder="Sesuai KTP" required/>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Pilih...</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
          <input type="tel" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required/>
        </div>
        <div class="col-12">
          <label class="form-label">Nama Perusahaan <span class="text-muted fw-normal">(opsional)</span></label>
          <input type="text" name="nama_perusahaan" class="form-control" placeholder="Jika ada"/>
        </div>
        <div class="col-12">
          <label class="form-label">Alamat <span class="text-danger">*</span></label>
          <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap" required></textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Foto KTP <span class="text-danger">*</span></label>
          <input type="file" name="foto_ktp" class="form-control" accept="image/jpeg,image/png" required/>
          <div class="form-text">Format JPG/PNG, maksimal 2MB</div>
        </div>
      </div>

      <!-- AKUN -->
      <div class="section-divider"><i class="bi bi-shield-lock me-1"></i> Data Akun</div>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required/>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" id="pass1" required oninput="checkStrength(this.value)"/>
            <span class="input-group-text" onclick="togglePass('pass1', 'eye1')">
              <i class="bi bi-eye" id="eye1"></i>
            </span>
          </div>
          <div class="password-strength bg-secondary" id="strengthBar"></div>
          <div class="form-text" id="strengthText"></div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password" id="pass2" required/>
            <span class="input-group-text" onclick="togglePass('pass2', 'eye2')">
              <i class="bi bi-eye" id="eye2"></i>
            </span>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn-daftar">
          <i class="bi bi-person-check me-2"></i>Buat Akun
        </button>
      </div>
    </form>
  </div>
  <div class="auth-footer">
    Sudah punya akun? <a href="<?= BASE_URL ?>/auth/login">Masuk di sini</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
  }

  function checkStrength(val) {
    const bar  = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const levels = [
      { color: '#ef4444', width: '25%', label: 'Lemah' },
      { color: '#f97316', width: '50%', label: 'Cukup' },
      { color: '#eab308', width: '75%', label: 'Baik' },
      { color: '#22c55e', width: '100%', label: 'Kuat' },
    ];
    const lvl = levels[strength - 1] || { color: '#e5e7eb', width: '0%', label: '' };
    bar.style.background = lvl.color;
    bar.style.width = lvl.width;
    text.textContent = lvl.label ? 'Kekuatan: ' + lvl.label : '';
    text.style.color = lvl.color;
  }
</script>
</body>
</html>
