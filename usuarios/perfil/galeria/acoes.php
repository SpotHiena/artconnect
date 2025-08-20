<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['USER'])) {
  header('Location: ../../login/login.php');
  exit;
}

$id_usuario = $_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // ID do artista passado na URL
  $id_get = isset($_GET['id']) ? intval($_GET['id']) : 0;

  // Consulta pelas artes do artista especificado na URL
  $sql = "SELECT * FROM artes WHERE artista_id = $id_get ORDER BY data_publicacao DESC";
  $res = mysqli_query($conexao, $sql);

  if (!$res || mysqli_num_rows($res) === 0) {
    echo "<p style='text-align:center;'>Nenhuma arte cadastrada.</p>";
    exit;
  }

  // Verifica se é o dono da conta
  $eh_dono = ($id_get === $id_usuario);

  while ($arte = mysqli_fetch_assoc($res)) {
    $imagem = (!empty($arte['imagem']) && file_exists("../../../images/produtos/{$arte['imagem']}"))
      ? "../../../images/produtos/{$arte['imagem']}"
      : "../../../assets/img/placeholder-produto.jpg";

    $tags = [];
    $tagRes = mysqli_query($conexao, "SELECT t.nome FROM arte_tag at JOIN tags t ON at.tag_id = t.id WHERE at.arte_id = {$arte['id']}");
    while ($t = mysqli_fetch_assoc($tagRes)) {
      $tags[] = '#' . htmlspecialchars($t['nome']);
    }
    $tags_str = implode(' ', $tags);

    // CORREÇÃO: dono é se a arte pertence ao usuário logado
    $data_dono = ($arte['artista_id'] == $_SESSION['ID']) ? 'true' : 'false';

    ?>
    <div class="card-arte"
         data-id="<?= $arte['id'] ?>"
         data-titulo="<?= htmlspecialchars($arte['titulo']) ?>"
         data-descricao="<?= htmlspecialchars($arte['descricao']) ?>"
         data-tags="<?= $tags_str ?>"
         data-preco="<?= number_format($arte['preco'], 2, ',', '.') ?>"
         data-imagem="<?= $imagem ?>"
         data-dono="<?= $data_dono ?>">
      <img src="<?= $imagem ?>" alt="<?= htmlspecialchars($arte['titulo']) ?>">
    </div>
    <?php
}

  exit;
}


// CADASTRAR ARTE
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_arte') {
  $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
  $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
  $preco = floatval(str_replace(',', '.', $_POST['preco']));
  $desconto = isset($_POST['desconto']) ? floatval(str_replace(',', '.', $_POST['desconto'])) : 0;
  $promocao = isset($_POST['promocao']) ? intval($_POST['promocao']) : 0;

  $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
  $preco_final = $preco - $preco_promocao;

  if ($preco_final < 0) {
    $_SESSION['mensagem'] = "Desconto inválido.";
    header('Location: inserir.php');
    exit;
  }

  // UPLOAD
  $imagem = '';
  if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === 0) {
    $imagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
    $destino = "../../../images/produtos/" . $imagem;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
  }

  $sql = "INSERT INTO artes (titulo, descricao, imagem, artista_id, preco, desconto, preco_promocao, preco_final, data_publicacao, promocao) VALUES (
    '$titulo', '$descricao', '$imagem', $id_usuario, $preco, $desconto, $preco_promocao, $preco_final, NOW(), $promocao
  )";

  if (mysqli_query($conexao, $sql)) {
    $arte_id = mysqli_insert_id($conexao);

    if (!empty($_POST['tags']) && is_array($_POST['tags'])) {
      foreach ($_POST['tags'] as $tag_id) {
        $tag_id = intval($tag_id);
        mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($arte_id, $tag_id)");
      }
    }

    $_SESSION['mensagem'] = "Arte cadastrada com sucesso!";
    header('Location: inserir.php');
    exit;
  } else {
    $_SESSION['mensagem'] = "Erro ao cadastrar arte: " . mysqli_error($conexao);
    header('Location: inserir.php'); 
    exit;
  }
}


// ATUALIZAR ARTE
if (isset($_POST['atualizar']) && $_POST['atualizar'] === 'atualizar_arte') {
  $id_arte = intval($_POST['id']);

  // ISSO AQUI VERIFICA SE A ARTE PERTENCE AO ARTISTA
  $check = mysqli_query($conexao, "SELECT id FROM artes WHERE id = $id_arte AND artista_id = $id_usuario");
  if (mysqli_num_rows($check) === 0) {
    $_SESSION['mensagem'] = "Você não tem permissão para editar esta arte.";
    header('Location: inserir.php');
    exit;
  }

  $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
  $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
  $preco = floatval(str_replace(',', '.', $_POST['preco']));
  $desconto = floatval(str_replace(',', '.', $_POST['desconto']));
  $promocao = isset($_POST['promocao']) ? intval($_POST['promocao']) : 0;

  $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
  $preco_final = $preco - $preco_promocao;

  if ($preco_final < 0) {
    $_SESSION['mensagem'] = "Desconto inválido.";
    header('Location: inserir.php');
    exit;
  }

  // PARTE DE SUBSTITUIR
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
    $imagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
    $destino = "../../../images/produtos/" . $imagem;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
  } else {
    $imagem = mysqli_real_escape_string($conexao, $_POST['imagem_atual']);
  }

  // ATT AS TAGS
  if (isset($_POST['tags']) && is_array($_POST['tags'])) {
    mysqli_query($conexao, "DELETE FROM arte_tag WHERE arte_id = $id_arte");
    foreach ($_POST['tags'] as $tag_id) {
      $tag_id = intval($tag_id);
      mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($id_arte, $tag_id)");
    }
  }

  $sql = "UPDATE artes SET titulo = '$titulo', descricao = '$descricao', preco = $preco, desconto = $desconto, preco_promocao = $preco_promocao, preco_final = $preco_final, promocao = $promocao, imagem = '$imagem' WHERE id = $id_arte AND artista_id = $id_usuario";

  if (mysqli_query($conexao, $sql)) {
  $_SESSION['mensagem'] = "Arte atualizada com sucesso!";
  header('Location: editar-arte.php?id=' . $id_arte);
  exit;
} else {
  $_SESSION['mensagem'] = "Erro ao atualizar arte: " . mysqli_error($conexao);
  header('Location: editar-arte.php?id=' . $id_arte);
  exit;
}
}

// EXCLUIR ARTE
if (isset($_POST['deletar'])) {
  $id_arte = intval($_POST['deletar']);

 //VERUIFICAÇÃO PARA EXCLUSÃO
  $check = mysqli_query($conexao, "SELECT id FROM artes WHERE id = $id_arte AND artista_id = $id_usuario");
  if (mysqli_num_rows($check) === 0) {
    $_SESSION['mensagem'] = "Você não tem permissão para excluir esta arte.";
    header('Location: inserir.php');
    exit;
  }

  $sql = "DELETE FROM artes WHERE id = $id_arte AND artista_id = $id_usuario";

  if (mysqli_query($conexao, $sql)) {
    $_SESSION['mensagem'] = "Arte excluída com sucesso!";
    header('Location: inserir.php');
    exit;
  } else {
    $_SESSION['mensagem'] = "Erro ao excluir arte: " . mysqli_error($conexao);
    header('Location: inserir.php');
    exit;
  }
}
?>
