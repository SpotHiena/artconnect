<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
    header('Location: ../../login/login.php');
    exit;
}

$id_usuario = $_SESSION['ID'];

// ====================== CADASTRAR CONTATO ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
    
    $nome   = mysqli_real_escape_string($conexao, $_POST['nome']);
    $rede   = mysqli_real_escape_string($conexao, $_POST['rede']);
    $url    = mysqli_real_escape_string($conexao, $_POST['url']);
    $status = intval($_POST['status']);

    // Normaliza a rede: primeira letra maiúscula, resto minúsculo
    $rede = ucfirst(strtolower(trim($rede)));

    $sql = "INSERT INTO contato (nome, rede, url, status, artista_rede) 
            VALUES ('$nome', '$rede', '$url', $status, $id_usuario)";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Contato cadastrado com sucesso!";
        header('Location: inserir.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar contato: " . mysqli_error($conexao);
        header('Location: inserir.php');
        exit;
    }
}

// ====================== EDITAR CONTATO ======================
if (isset($_POST['acao']) && $_POST['acao'] === 'editar' && isset($_POST['id'])) {
    $id_contato = intval($_POST['id']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $rede = mysqli_real_escape_string($conexao, $_POST['rede']);
    $url  = mysqli_real_escape_string($conexao, $_POST['url']);
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    // Normaliza a rede aqui também
    $rede = ucfirst(strtolower(trim($rede)));

    $sql = "UPDATE contato 
            SET nome='$nome', rede='$rede', url='$url', status=$status
            WHERE id=$id_contato AND artista_rede=$id_usuario";
    mysqli_query($conexao, $sql);

    $_SESSION['mensagem'] = "Contato atualizado com sucesso!";
    header("Location: contatos.php?id=$id_usuario");
    exit;
}

// ====================== EXCLUIR CONTATO ======================
if (isset($_GET['excluir']) && is_numeric($_GET['excluir'])) {
    $id_contato = intval($_GET['excluir']);
    mysqli_query($conexao, "DELETE FROM contato WHERE id=$id_contato AND artista_rede=$id_usuario");

    $_SESSION['mensagem'] = "Contato excluído com sucesso!";
    header("Location: contatos.php?id=$id_usuario");
    exit;
}
