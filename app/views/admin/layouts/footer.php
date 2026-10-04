</main><!-- end main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleSidebar() {
  const sidebar  = document.getElementById('sidebar');
  const overlay  = document.getElementById('sidebarOverlay');
  const isOpen   = sidebar.classList.contains('show');
  sidebar.classList.toggle('show', !isOpen);
  overlay.style.display = isOpen ? 'none' : 'block';
}
</script>
<?php if (isset($extraScript)) echo $extraScript; ?>
</body>
</html>