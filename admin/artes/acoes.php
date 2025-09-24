<?php
require_once '../../conexao.php';
if (!isset($_SESSION))
  session_start();

if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_arte') {
  $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
  $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
  $preco = floatval(str_replace(',', '.', $_POST['preco']));
  $desconto = isset($_POST['desconto']) ? floatval(str_replace(',', '.', $_POST['desconto'])) : 0;
  $promocao = mysqli_real_escape_string($conexao, $_POST['promocao']);
  $imagem = basename($_FILES['imagem']['name']);
  $tmp = $_FILES['imagem']['tmp_name'];
  $final = "../../images/produtos/" . $imagem;
  move_uploaded_file($tmp, $final);

  $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
  $preco_final = $preco - $preco_promocao;

  if ($preco_final < 0) {
    $_SESSION['mensagem'] = "Desconto inválido.";
    header('Location: inserir.php');
    exit;
  }

  $artista_id = $_SESSION['usuario_id'] ?? 1;

  $sql = "INSERT INTO artes (
    titulo, descricao, imagem, artista_id, preco, desconto, preco_promocao, preco_final, data_publicacao, promocao
  ) VALUES (
    '$titulo', '$descricao', '$imagem', $artista_id, $preco, $desconto, $preco_promocao, $preco_final, NOW(), $promocao
  )";

  if (mysqli_query($conexao, $sql)) {
    $arte_id = mysqli_insert_id($conexao);

    if (!empty($_POST['tags']) && is_array($_POST['tags'])) {
      foreach ($_POST['tags'] as $tag_id) {
        $tag_id = intval($tag_id);
        mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($arte_id, $tag_id)");
      }
    }

    $_SESSION['mensagem'] = "Arte cadastrado com sucesso!";
    header('Location: inserir.php');
    exit;
  } else {
    $_SESSION['mensagem'] = "Erro ao cadastrar!";
    header('Location: inserir.php');
    die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
  }
}

// ATUALIZAR

if (isset($_POST['atualizar']) && $_POST['atualizar'] == 'atualizar_arte') {
  $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
  $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
  $preco = floatval(str_replace(',', '.', $_POST['preco']));
  $desconto = floatval(str_replace(',', '.', $_POST['desconto']));
  $codigo = mysqli_real_escape_string($conexao, $_POST['id']);
  $promocao = mysqli_real_escape_string($conexao, $_POST['promocao']);

  // ESSE IF É PARA AS IMAGENS SEREM TROCADAS, SE TIVER IMAGEM ENTAO NAO TROCA MAS SE NAO TIVER ENTAO PODE ADICIONAR
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $imagem = basename($_FILES['imagem']['name']);
    $tmp = $_FILES['imagem']['tmp_name'];
    $final = "../../images/produtos/" . $imagem;
    move_uploaded_file($tmp, $final);
  } else {
    $imagem = $_POST['imagem_atual'];
  }

  // ESSE AQUI É PRA TUALIZAR A ONT CASO SEJA ATUALIZADA
  $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
  $preco_final = $preco - $preco_promocao;

  if ($preco_final < 0) {
    $_SESSION['mensagem'] = "Desconto inválido.";
    header("Location:editar.php");
    exit;
  }

  // ISSO AQUI FAZ COM QUE AS TAGS DO CODIGO SEJAM DELETADAS CASO EU VA EDITAR E RETIRAR A TAGS DE UMA ARTE, TEM QUE SER DELETE POR QUE É N:N

  if (isset($_POST['tags']) && is_array($_POST['tags'])) {
    mysqli_query($conexao, "DELETE FROM arte_tag WHERE arte_id = $codigo");

    // ESSE AQUI É AQUELE FOR EACH DA TABELA QUE SERVE PRA INSERIR NOVAS
    foreach ($_POST['tags'] as $tag_id) {
        $tag_id = intval($tag_id);
        mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($codigo, $tag_id)");
    }
}

  $sql = "UPDATE artes SET  titulo='$titulo', descricao='$descricao', preco='$preco', desconto='$desconto', preco_promocao='$preco_promocao', preco_final='$preco_final', promocao=$promocao";


  if (!empty($imagem)) {
    $sql .= ", imagem = '$imagem'";
  }
  
  $sql .= " WHERE id = $codigo";
  

if (mysqli_query($conexao, $sql)) {
   $_SESSION['mensagem'] = "Arte atualizada com sucesso!";
   header("Location: inserir.php");
   exit;
 } else {
   $_SESSION['mensagem'] = "Erro ao atualizar!";
   header("Location: inserir.php");
  die("Erro: " . mysqli_error($conexao));
}
}  
 if(isset($_POST['deletar']))
     {
            $codigo = $_POST['deletar'];
               
              $sql = "DELETE FROM artes WHERE id = $codigo";
        if(mysqli_query($conexao, $sql))
        {
            $_SESSION['mensagem'] = "Arte excluido com sucesso!"; 
            header('Location: index.php');
        }
        else{
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao));   
     }
     }
     ?>