<?php
session_start();

// Pega o ID da URL
$id_usuario = isset($_GET['id']) && is_numeric($_GET['id'])
    ? intval($_GET['id'])
    : 0; // se não tiver ID, pode tratar como erro ou redirecionar

// Página atual (para destacar o link ativo)
$pagina_atual = basename($_SERVER['PHP_SELF']);

// Verifica se o visitante logado é o dono do perfil
$proprio_usuario = isset($_SESSION['ID']) && $_SESSION['ID'] == $id_usuario;
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
        <li class="<?= $pagina_atual == 'contatos.php' ? 'ativo' : '' ?>">
            <a href="../contatos/contatos.php?id=<?= $id_usuario ?>">📱 Contatos</a>
        </li>
    </ul>
</aside>
