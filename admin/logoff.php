<?php 

if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
  session_start();
}

unset ($_SESSION['USER'], $_SESSION['TYPE']);
    $_SESSION['logOff'] = "LogOff realizado com sucesso!";
    header('Location: index.php')
?>