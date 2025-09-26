<?php
if (!isset($_SESSION)) {
    session_start();
}

$nome_usuario = isset($_SESSION['USER']) ? $_SESSION['USER'] : null;

// URL base fixa para evitar duplicação de pastas
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/artconnect/usuarios/";
?>

<link rel="stylesheet" href="/artconnect/css/topo.css">

<header>
    <!-- Logo com nome ao lado -->
    <a href="<?= $base_url ?>inicio.php" class="logo" style="display: flex; align-items: center; text-decoration: none;">
        <img src="/artconnect/images/assets/img/logo.png" alt="Art Connect" height="50" style="margin-right: 10px;">
        <span style="font-size: 1.5rem; color: #000; font-weight: bold;">Art Connect</span>
    </a>

    <button class="nav-toggle">☰</button>

    <nav>
        <div class="nav-links">
            <ul>
                <li><a href="<?= $base_url ?>inicio.php">Início</a></li>
                <li><a href="<?= $base_url ?>artista.php">Artistas</a></li>
                <li><a href="<?= $base_url ?>guia.php">Guia de Compras</a></li>
                <li><a href="<?= $base_url ?>catalogo/catalogo.php">Catálogo</a></li>

                <?php if (!$nome_usuario): ?>
                    <li><a href="<?= $base_url ?>login/login.php" class="login-btn">Login / Registro</a></li>
                <?php else: ?>
                    <li class="dropdown">
                        <div class="dropdown-toggle"><?= htmlspecialchars($nome_usuario) ?></div>
                        <div class="dropdown-content">
                            <a href="<?= $base_url ?>perfil/perfil/usuario.php">Perfil</a>
                            <a href="<?= $base_url ?>perfil/perfil/editar-perfil.php">Editar Perfil</a>
                            <a href="<?= $base_url ?>login/logoff.php" onclick="return confirm('Tem certeza que deseja sair?')">Sair</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <form class="busca" action="<?= $base_url ?>search.php" method="get">
            <input type="search" name="busca" placeholder="Pesquise por estilo, nome...">
            <button type="submit">Buscar</button>
        </form>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.nav-links');

    toggle.addEventListener('click', function() {
        nav.classList.toggle('active');
    });
});
</script>
