<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
    header('Location: ../../login/login.php');
    exit;
}

// Pega o ID do usuário da URL ou, se não existir, usa o ID do usuário logado
$id_usuario = isset($_GET['id']) && is_numeric($_GET['id'])
    ? intval($_GET['id'])
    : intval($_SESSION['ID']);

// Página atual (para destacar o link ativo)
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="/artconnect/css/navegacao.css">

<!-- Botão para abrir/fechar o menu -->
<input type="checkbox" id="menu-toggle" class="menu-toggle" />
<label for="menu-toggle" class="menu-btn">☰</label>

<aside class="menu-lateral">
    <h2>Gerenciar</h2>
    <ul>
        <li class="<?= $pagina_atual == 'usuario.php' ? 'ativo' : '' ?>">
            <a href="../perfil/usuario.php?id=<?= $id_usuario ?>">👤 Perfil</a>
        </li>
        <li class="<?= $pagina_atual == 'galeria.php' ? 'ativo' : '' ?>">
            <a href="../galeria/galeria.php?id=<?= $id_usuario ?>">🖼️ Galeria</a>
        </li>

    </ul>
</aside>
