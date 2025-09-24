<?php
//CONEXAO COOM O BANCO DE DADOS
require_once '../conexao.php';
if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
    session_start();
}

if (isset($_POST['usuario']) && $_POST['usuario'] != '' && isset($_POST['senha']) && $_POST['senha'] != '') {
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = "SELECT * FROM funcionario WHERE usuario = '$usuario' AND senha= '$senha'";
    $query = mysqli_query($conexao, $sql);
    $funcionario = mysqli_fetch_assoc($query);

    // echo $funcionario['usuario'];
    // echo ' ';
    // echo $funcionario['senha'];
    // echo ' ';
    // echo $funcionario['tipo_acesso'];
    // echo ' ';
    if(isset($funcionario))
    {
        $_SESSION['ID'] = $funcionario['codigo_funcionario'];
        $_SESSION['USER'] = $funcionario['usuario'];
        $_SESSION['TYPE'] = $funcionario['tipo_acesso'];
        $_SESSION['NAME'] = $funcionario['nome'];

        header('Location: admin.php');
    }else{
        $_SESSION ['loginErro'] = 'Usuario ou senha inválidos.';
        header('Location: index.php');
    }
} 
else 
{
    $_SESSION['loginVazio'] = 'Informe usuário e senha.';
    header('Location: index.php');

}
?>