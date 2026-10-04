<!-- FOOTER -->
<footer style="background:var(--steel);padding:3rem 0 1.5rem;border-top:2px solid var(--orange);margin-top:auto;">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div style="display:flex;align-items:center;gap:0.7rem;margin-bottom:0.7rem;">
          <img src="<?= BASE_URL ?>/public/images/logo.jpeg" alt="HK Satu Tujuh" style="height:46px;width:46px;object-fit:cover;border-radius:8px;"/>
          <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;color:#fff;">
            HKSATU<span style="color:var(--orange);">TUJUH</span>
          </div>
        </div>
        <p style="color:rgba(255,255,255,0.5);font-size:0.85rem;line-height:1.7;max-width:260px;">
          Platform penyewaan alat konstruksi terpercaya. Kami hadir untuk mempermudah proyek Anda dengan alat berkualitas.
        </p>
        <div class="d-flex gap-2 mt-3">
          <a href="#" style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="#" style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-whatsapp"></i>
          </a>
          <a href="#" style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'">
            <i class="bi bi-facebook"></i>
          </a>
        </div>
      </div>
      <div class="col-md-2">
        <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:0.88rem;margin-bottom:1rem;">Menu</div>
        <a href="<?= BASE_URL ?>/" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Beranda</a>
        <a href="<?= BASE_URL ?>/home/katalog" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Katalog Alat</a>
        <a href="<?= BASE_URL ?>/home/caraSewa" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Cara Sewa</a>
        <a href="<?= BASE_URL ?>/home/tentangKami" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Tentang Kami</a>
      </div>
      <div class="col-md-2">
        <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:0.88rem;margin-bottom:1rem;">Akun</div>
        <a href="<?= BASE_URL ?>/auth/login" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Masuk</a>
        <a href="<?= BASE_URL ?>/auth/register" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Daftar</a>
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'pelanggan'): ?>
        <a href="<?= BASE_URL ?>/penyewaan/riwayat" style="display:block;color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.5rem;text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">Riwayat Sewa</a>
        <?php endif; ?>
      </div>
      <div class="col-md-4">
        <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:0.88rem;margin-bottom:1rem;">Kontak</div>
        <div style="color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.6rem;">
          <i class="bi bi-telephone me-2" style="color:var(--orange);"></i>0822-5870-7017
        </div>
        <div style="color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.6rem;">
          <i class="bi bi-envelope me-2" style="color:var(--orange);"></i>hksatutujuh2024@gmail.com
        </div>
        <div style="color:rgba(255,255,255,0.5);font-size:0.83rem;margin-bottom:0.6rem;">
          <i class="bi bi-geo-alt me-2" style="color:var(--orange);"></i>Bandar Lampung, Indonesia
        </div>
        <div style="color:rgba(255,255,255,0.5);font-size:0.83rem;">
          <i class="bi bi-clock me-2" style="color:var(--orange);"></i>Senin–Sabtu, 08.00–17.00
        </div>
      </div>
    </div>
    <hr style="border-color:rgba(255,255,255,0.08);margin:2rem 0 1rem;"/>
    <div class="text-center" style="color:rgba(255,255,255,0.3);font-size:0.78rem;">
      © <?= date('Y') ?> CV. HK Satu Tujuh. Hak cipta dilindungi undang-undang.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
