<?php
// CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';

if (!isset($_SESSION)) {
  session_start();
}

// CADASTRAR UMA NOVA TAG
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_tag') {
  $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

  // Inserção no banco (id, nome, status, data_cadastro)
  $sql = "INSERT INTO tags VALUES (0,'$nome', '$observacao', 1)";

  if (mysqli_query($conexao, $sql)) {
    $_SESSION['mensagem'] = "Tag cadastrada com sucesso!";
    header('Location: inserir.php');
  } else {
    $_SESSION['mensagem'] = "Erro ao cadastrar a tag!";
    header('Location: inserir.php');
  }
}

// ATUALIZAR
if (isset($_POST['atualizar']) && $_POST['atualizar'] == 'atualizar_tags') {
  $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
  $status = mysqli_real_escape_string($conexao, $_POST['status']);
  $codigo = mysqli_real_escape_string($conexao, $_POST['id']);

  // Inserção no banco (id, nome, status, data_cadastro)
  $sql = "UPDATE tags SET nome='$nome', observacao = '$observacao', status= $status";

   $sql .= " WHERE id = $codigo";


  if (mysqli_query($conexao, $sql)) {
    $_SESSION['mensagem'] = "Tag atualizada com sucesso!";
    header('Location: inserir.php');
  } else {
    $_SESSION['mensagem'] = "Erro ao atualizar a tag!";
    header('Location: inserir.php');
  }
 }
 if(isset($_POST['deletar']))
     {
            $codigo = $_POST['deletar'];
               
              $sql = "DELETE FROM tags WHERE id = $codigo";
        if(mysqli_query($conexao, $sql))
        {
            $_SESSION['mensagem'] = "Tag excluida com sucesso!"; 
            header('Location: index.php');
        }
        else{
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao));   
     }
     }
     ?>
