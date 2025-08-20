<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
  header('Location: ../../login/login.php');
  exit;
}

// Pega o ID direto da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id_usuario = intval($_GET['id']);
} else {
  echo "ID do usuário não informado.";
  exit;
}

$sql = "SELECT apelido, foto, nome, descricao 
        FROM usuarios 
        WHERE id = $id_usuario 
        LIMIT 1";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
  echo "Usuário não encontrado.";
  exit;
}

$usuario = mysqli_fetch_assoc($resultado);

$apelido = htmlspecialchars($usuario['apelido']);
$foto = (!empty($usuario['foto']) && file_exists("../../../images/produtos/{$usuario['foto']}"))
  ? "../../../images/produtos/{$usuario['foto']}"
  : "../../../images/assets/img/placeholder-funcionario.png";
$nome_completo = htmlspecialchars($usuario['nome']);
$descricao = htmlspecialchars($usuario['descricao']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Galeria do Usuário - ArtConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../../../css/galeria.css">
  <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">


</head>
<?php include("../../topo.php"); ?>


<body>
  <main class="container-usuario">

    <?php include("../navegacao.php"); ?>

    <section class="perfil-top mb-4">
      <div class="avatar">

        <img
          src="<?= !empty($usuario['foto']) ? '../../../images/perfil/' . htmlspecialchars($usuario['foto']) : '../../../images/assets/img/placeholder-funcionario.png' ?>"
          alt="Foto de perfil" class="profile-pic" />

      </div>

      <div class="info">
        <h3><?php echo $apelido; ?>
          <?php if ($nome_completo)
            echo "<small style='font-weight:600; font-size:0.85rem; color:#9b627a'>&nbsp;&middot;&nbsp;{$nome_completo}</small>"; ?>
        </h3>
        <p> <?php echo $descricao; ?></p>
      </div>

      <div class="perfil-actions">
        <?php if ($_SESSION['ID'] == $id_usuario): ?>
          <a href="inserir.php" class="btn btn-pastel">+ Nova Arte</a>
        <?php endif; ?>
      </div>

    </section>
    <?php include '../../mensagem.php'; ?>
    <section class="galeria">
      <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <h2 class="titulo-aba">Minhas Artes</h2>
      </div>
      <div class="linha-separadora"></div>

      <div id="galeria-cards" class="mt-3">
      </div>

      <div id="msg-area" class="mt-4"></div>
    </section>
  </main>

  <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body text-center">
          <div class="modal-imagem-wrapper mb-3">
            <img id="modalImagem" class="modal-imagem img-fluid" src="" alt="Imagem da arte" />
          </div>

          <h2 id="modalTitulo" class="text-rosa-4 mb-2"></h2>
          <p id="modalDescricao"></p>
          <p><strong>Tags:</strong> <span id="modalTags"></span></p>
          <p><strong>Preço:</strong> R$ <span id="modalPreco"></span></p>

          <div class="modal-botoes d-flex justify-content-center gap-3 mt-3">
            <a id="btnEditar" href="#" class="btn btn-pastel">Editar</a>
            <button id="btnExcluir" class="btn btn-outline-danger">Excluir</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../js/galeria.js"></script>
</body>
<footer class="bg-rose text-white py-3 text-center rounded-top">
  <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>


</html>