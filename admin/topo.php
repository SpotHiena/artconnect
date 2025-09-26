<?php
if (!isset($_SESSION)) {
    session_start();
}

// URL base fixa do admin
$admin_base_url = "http://" . $_SERVER['HTTP_HOST'] . "/artconnect/admin/";
?>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 px-3" href="<?= $admin_base_url ?>admin.php">ArtConnect</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="<?= $admin_base_url ?>logoff.php" onclick="return confirm('Tem certeza que deseja sair?')">Sair</a>
    </div>
  </div>
</header>
