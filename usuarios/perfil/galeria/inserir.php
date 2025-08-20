<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['USER'])) {
  header('Location: ../../login/login.php');
  exit;
}

$tags = [];
$sqlTags = "SELECT * FROM tags WHERE status = 1 ORDER BY nome ASC";
$result = mysqli_query($conexao, $sqlTags);
while ($row = mysqli_fetch_assoc($result)) {
  $tags[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar Arte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../css/inserir.css">
     <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">

</head>

<body>
  <header>
    <?php include("../../topo.php"); ?>
  </header>

  <div class="container form-container">
    <a href="galeria.php" class="btn btn-outline-secondary btn-sm btn-voltar">← Voltar</a>

    <h2 class="form-title">Cadastrar Arte</h2>
    <?php include '../../mensagem.php'; ?>
    <form action="acoes.php" method="post" enctype="multipart/form-data">

      <div class="mb-3">
        <div class="preview" id="preview">
          <span>Pré-visualização da imagem</span>
        </div>
        <input class="form-control" type="file" name="imagem" accept="image/*">
      </div>

      <div class="mb-3">
        <label for="titulo" class="form-label">Título:</label>
        <input type="text" name="titulo" class="form-control" required>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label for="descricao" class="form-label">Descrição:</label>
          <textarea name="descricao" class="form-control" rows="2"></textarea>
        </div>
        <div class="col-md-6">
          <label for="tags">Tags:</label>
          <select name="tags[]" id="tags" class="form-control select2" multiple>
            <?php foreach ($tags as $tag): ?>
              <option value="<?= $tag['id'] ?>">#<?= htmlspecialchars($tag['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-label mt-3">Promoção?</div>
      <div class="radio-promo">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="promocao" id="promocao_sim" value="1">
          <label class="form-check-label" for="promocao_sim">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="promocao" id="promocao_nao" value="0" checked>
          <label class="form-check-label" for="promocao_nao">Não</label>
        </div>
      </div>

      <div class="precos-linha">
        <div>
          <label for="preco" class="form-label">Preço de Venda:</label>
          <input type="text" name="preco" id="preco" class="form-control" data-mask="000000,00" data-mask-reverse="true" required>
        </div>
        <div>
          <label for="desconto" class="form-label">% Desconto:</label>
          <div class="input-group">
            <input type="text" name="desconto" id="desconto" class="form-control" disabled>
            <div class="input-group-append">
              <span class="input-group-text">%</span>
            </div>
          </div>
        </div>
        <div>
          <label for="preco_final" class="form-label">Preço Final:</label>
          <input type="text" id="preco_final" class="form-control" readonly>
        </div>
      </div>

      <div class="form-group mt-2">
        <strong id="mensagem_erro" class="form-text text-danger" style="display: none;">* O desconto não pode ser maior que o preço!</strong>
      </div>

      <input type="hidden" name="cadastrar" value="cadastrar_arte">

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-laranja">Cadastrar Arte</button>
      </div>

    </form>
  </div>

  <script>
    document.querySelector('input[name="imagem"]').addEventListener('change', function(e) {
      const preview = document.getElementById('preview');
      const file = e.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          preview.innerHTML = `<img src="${event.target.result}" alt="Prévia">`;
        };
        reader.readAsDataURL(file);
      } else {
        preview.innerHTML = `<span>Pré-visualização da imagem</span>`;
      }
    });
  </script>

  <!-- JS BÁSICO -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SEUS ARQUIVOS JS -->
  <script src="../../../js/jquery.mask.js"></script>
  <script src="../../../js/conta.js"></script>

</body>
<footer class="bg-rose text-white py-3 text-center rounded-top">
  <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>

</html>