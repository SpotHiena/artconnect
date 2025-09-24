<?php

require_once '../../conexao.php';
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['apelido']) && $_POST['apelido'] != '' && isset($_POST['senha']) && $_POST['senha'] != '') {
    $usuarioInput = mysqli_real_escape_string($conexao, $_POST['apelido']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE (apelido = '$usuarioInput' OR email = '$usuarioInput') AND senha = '$senha'";
    $query = mysqli_query($conexao, $sql);
    $usuarios = mysqli_fetch_assoc($query);

    if (isset($usuarios)) {
        $_SESSION['ID'] = $usuarios['id'];
        $_SESSION['USER'] = $usuarios['apelido'];
        $_SESSION['TYPE'] = $usuarios['tipo'];
        $_SESSION['NAME'] = $usuarios['nome'];

        header('Location: ../inicio.php');
    } else {
        $_SESSION['loginErro'] = 'Usuário ou senha inválidos.';
        header('Location: index.php');
    }
} else {
    $_SESSION['loginVazio'] = 'Informe usuário e senha.';
    header('Location: index.php');
}
?>
