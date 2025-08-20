<?php
//CONEXAO COOM O BANCO DE DADOS
require_once '../conexao.php';
if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
  session_start();
}

#VERIFICANDO SE EXISTE USUARIO LOGADO PARA PERMITIR ACESSO#

if (!$_SESSION['USER']) {
  $_SESSION['naoAutorizado'] = "Apenas usuarios cadastrados podem acessar esta área!";
  header('Location: ../index.php');
}

?>