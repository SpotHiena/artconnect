<?php 

if (!isset($_SESSION)) 
{
  session_start();
}

unset ($_SESSION['USER'], $_SESSION['TYPE']);
    $_SESSION['logOff'] = "LogOff realizado com sucesso!";
    header('Location: index.php')
?>