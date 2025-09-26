<?php
require_once '../conexao.php';
if (!isset($_SESSION)) {
    session_start();
}

// URL base fixa do admin
$admin_base_url = "http://" . $_SERVER['HTTP_HOST'] . "/artconnect/admin/";

if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = "SELECT * FROM funcionario WHERE usuario = '$usuario' AND senha = '$senha'";
    $query = mysqli_query($conexao, $sql);
    $funcionario = mysqli_fetch_assoc($query);

    if ($funcionario) {
        $_SESSION['ID'] = $funcionario['codigo_funcionario'];
        $_SESSION['USER'] = $funcionario['usuario'];
        $_SESSION['TIPO'] = $funcionario['tipo_acesso']; // agora consistente com o topo
        $_SESSION['NAME'] = $funcionario['nome'];

        // Redireciona conforme tipo de acesso
        if ($_SESSION['TIPO'] == 1) { // admin
            header('Location: ' . $admin_base_url . 'admin.php');
        } else { // usuário comum
            header('Location: ../index.php');
        }
        exit;
    } else {
        $_SESSION['loginErro'] = 'Usuário ou senha inválidos.';
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['loginVazio'] = 'Informe usuário e senha.';
    header('Location: index.php');
    exit;
}
?>
