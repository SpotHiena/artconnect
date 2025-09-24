<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
  header('Location: ../../login/login.php');
  exit;
}

if (!isset($_GET['id']) || $_GET['id'] == '') {
  echo "<h5>ID da arte não fornecido</h5>";
  exit;
}

$codigo = intval($_GET['id']);

$tags = [];
$sqlTags = "SELECT * FROM tags WHERE status = 1 ORDER BY nome ASC";
$result = mysqli_query($conexao, $sqlTags);
while ($row = mysqli_fetch_assoc($result)) {
  $tags[] = $row;
}

// Buscar dados da arte e tags vinculadas
$sql = "SELECT a.*, t.id AS tag_id, t.nome AS tag_nome
        FROM artes a
        LEFT JOIN arte_tag at ON at.arte_id = a.id
        LEFT JOIN tags t ON t.id = at.tag_id
        WHERE a.id = $codigo";

$query = mysqli_query($conexao, $sql);

$arte = null;
$tags_arte = [];
while ($row = mysqli_fetch_assoc($query)) {
  if (!$arte) {
    $arte = $row;
  }
  if ($row['tag_id']) {
    $tags_arte[] = $row['tag_id'];
  }
}
if (!$arte) {
  echo "<h5>Arte não encontrada</h5>";
  exit;
}

// Buscar todas as tags para o select
$tags = [];
$sqlTags = "SELECT id, nome FROM tags WHERE status = 1 ORDER BY nome ASC";
$resultTags = mysqli_query($conexao, $sqlTags);
while ($rowTag = mysqli_fetch_assoc($resultTags)) {
  $tags[] = $rowTag;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Arte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../css/editar.css">
  <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<body>
  <header>
    <?php include("../../topo.php"); ?>
  </header>

  <div class="container form-container">
    <a href="galeria.php?id=<?= $arte['artista_id'] ?>" class="btn btn-outline-secondary btn-sm btn-voltar">← Voltar</a>


    <h2 class="form-title">Editar Arte</h2>
    <?php include '../../mensagem.php'; ?>

    <form action="acoes.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <!-- Preview BOX: quadrado com borda e imagem preenchendo com object-fit -->
        <div class="preview" id="preview">
          <div class="preview-box" id="previewBox">
            <?php
            $imgSrc = !empty($arte['imagem']) ? '../../../images/produtos/' . $arte['imagem'] : '../../../assets/img/default.jpg';
            ?>
            <img id="previewImg" src="<?php echo htmlspecialchars($imgSrc); ?>" alt="Prévia da imagem">
          </div>
        </div>

        <!-- input com onchange para atualizar a prévia -->
        <input class="form-control" type="file" name="imagem" accept="image/*" onchange="previewImage(event)" />
        <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($arte['imagem']); ?>" />
      </div>

      <div class="mb-3">
        <label for="titulo" class="form-label">Título:</label>
        <input type="text" name="titulo" class="form-control" required
          value="<?php echo htmlspecialchars($arte['titulo']); ?>" />
      </div>

      <div class="row">
        <div class="col-md-6">
          <label for="descricao" class="form-label">Descrição:</label>
          <textarea name="descricao" class="form-control"
            rows="2"><?php echo htmlspecialchars($arte['descricao']); ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="tags">Tags:</label>
          <select name="tags[]" id="tags" class="form-control select2" multiple>
            <?php
            foreach ($tags as $tag) {
              $selected = in_array($tag['id'], $tags_arte) ? 'selected' : '';
              echo '<option value="' . $tag['id'] . '" ' . $selected . '>#' . htmlspecialchars($tag['nome']) . '</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-label mt-3">Promoção?</div>
      <div class="radio-promo">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="promocao" id="promocao_sim" value="1" <?php if ($arte['promocao'] == 1)
            echo 'checked'; ?> />
          <label class="form-check-label" for="promocao_sim">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="promocao" id="promocao_nao" value="0" <?php if ($arte['promocao'] == 0)
            echo 'checked'; ?> />
          <label class="form-check-label" for="promocao_nao">Não</label>
        </div>
      </div>

      <div class="precios-linha">
        <div>
          <label for="preco" class="form-label">Preço de Venda:</label>
          <input type="text" name="preco" id="preco" class="form-control" data-mask="000000,00" data-mask-reverse="true"
            required value="<?php echo htmlspecialchars($arte['preco']); ?>" />
        </div>
        <div>
          <label for="desconto" class="form-label">% Desconto:</label>
          <div class="input-group">
            <input type="text" name="desconto" id="desconto" class="form-control"
              value="<?php echo htmlspecialchars($arte['desconto']); ?>" />
            <div class="input-group-append">
              <span class="input-group-text">%</span>
            </div>
          </div>
        </div>
        <div>
          <label for="preco_final" class="form-label">Preço Final:</label>
          <input type="text" id="preco_final" class="form-control" readonly
            value="<?php echo htmlspecialchars($arte['preco_final']); ?>" />
        </div>
      </div>

      <div class="form-group mt-2">
        <strong id="mensagem_erro" class="form-text text-danger" style="display: none;">* O desconto não pode ser maior
          que o preço!</strong>
      </div>

      <input type="hidden" name="atualizar" value="atualizar_arte" />
      <input type="hidden" name="id" value="<?php echo $codigo; ?>" />
      <input type="submit" value="Atualizar" class="btn btn-primary mt-3" />
    </form>
  </div>

  <!-- Preview script -->
  <script>
    function previewImage(event) {
      const file = event.target.files[0];
      const img = document.getElementById('previewImg');

      if (!file) {
        // se apagou o arquivo, restaura a imagem atual (ou placeholder)
        img.src = "<?php echo htmlspecialchars($imgSrc); ?>";
        return;
      }

      // usa URL.createObjectURL para preview imediato
      const url = URL.createObjectURL(file);
      img.src = url;

      // revoke depois que a imagem carregar para liberar memória
      img.onload = function () {
        URL.revokeObjectURL(url);
      }
    }
  </script>

  <!-- JS externos -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../js/jquery.mask.js"></script>
  <script src="../../../js/conta.js"></script>

  <script>
    // inicializa select2 se desejar
    $(document).ready(function () {
      if ($.fn.select2) {
        $('#tags').select2({
          width: '100%',
          placeholder: 'Selecione tags (opcional)'
        });
      }
    });
  </script>

</body>
<footer class="bg-rose text-white py-3 text-center rounded-top">
  <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>

</html>