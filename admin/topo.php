<?php 
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário é admin
if (!isset($_SESSION['ID']) || !isset($_SESSION['USER']) || !isset($_SESSION['TIPO']) || $_SESSION['TIPO'] != 1) {
    header('Location: ../../login/login.php');
    exit;
}

$usuario_nome = $_SESSION['USER'];

// URL base fixa do admin
$admin_base_url = "http://" . $_SERVER['HTTP_HOST'] . "/artconnect/admin/";
?>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 px-3" href="<?= $admin_base_url ?>admin.php">ArtConnect</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav ms-auto">
    <div class="nav-item dropdown">
      <a class="nav-link dropdown-toggle px-3 text-white" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?= htmlspecialchars($usuario_nome) ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
        <li><a class="dropdown-item" href="<?= $admin_base_url ?>perfil.php?id=<?= $_SESSION['ID'] ?>">Perfil</a></li>
        <li><a class="dropdown-item" href="<?= $admin_base_url ?>editar_perfil.php?id=<?= $_SESSION['ID'] ?>">Editar Perfil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?= $admin_base_url ?>logoff.php" onclick="return confirm('Tem certeza que deseja sair?')">Sair</a></li>
      </ul>
    </div>
  </div>
</header>
