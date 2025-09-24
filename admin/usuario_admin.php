<?php
//CONEXAO COOM O BANCO DE DADOS

if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
  session_start();
}
##VERIFICANDO SE O USUARIO LOGADO É ADMINISTRADOR
if($_SESSION['TYPE'] != '1')
{
   $_SESSION['naoAdm'] = "Apenas usuarios administradores podem acessar essa área!";

   header('Location: ../index.php');
}

?>