<?php
require_once '../../conexao.php';
 include_once '../usuario_admin.php';

$tags = [];
$sqlTags = "SELECT * FROM tags WHERE status = 1 ORDER BY nome ASC";
$result = mysqli_query($conexao, $sqlTags);
while ($row = mysqli_fetch_assoc($result)) {
  $tags[] = $row;
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>Cadastro de Arte</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  <link href="../../css/dashboard.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico">
</head>


<body>
  <?php include('../topo.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('../navegacao.php'); ?>


      <main class="ml-sm-auto col-lg-8 px-md-4 mt-5 d-flex justify-content-between align-items-center">
        <div class="card">
          <?php include '../mensagem.php'; ?>
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0">Cadastro de Arte</h4>
            <a href="index.php" class="btn btn-primary btn-sm">
              <i class="bi bi-arrow-left"></i> Voltar
            </a>
          </div>

          <div class="card-body">
            <form action="acoes.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="imagem"></label>
                <input type="file" name="imagem" class="form-control-file" accept="image/*" required>
              </div>

              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="titulo">Título:</label>
                  <input type="text" name="titulo" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                  <label for="tags">Tags:</label>
                  <select name="tags[]" id="tags" class="form-control select2" multiple>
                    <?php foreach ($tags as $tag): ?>
                      <option value="<?= $tag['id'] ?>">#<?= htmlspecialchars($tag['nome']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="descricao">Descrição:</label>
                  <textarea name="descricao" class="form-control" rows="2"></textarea>
                </div>
              </div>


              <div class="form-row">
                <div class="form-group col-md-2">
                  <label for="preco">Preço de Venda:</label>
                  <input type="text" name="preco" id="preco" class="form-control" data-mask="000000,00" data-mask-reverse="true" required>
                </div>
              </div>

              <div class="form-row align-items-end">
                <div class="form-group col-md-3">
                  <label>Promoção?</label><br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="promocao" id="promocao_sim" value="1">
                    <label class="form-check-label" for="promocao_sim">Sim</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="promocao" id="promocao_nao" value="0" checked>
                    <label class="form-check-label" for="promocao_nao">Não</label>
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <label for="desconto">% Desconto:</label>
                  <div class="input-group">
                    <input type="text" name="desconto" id="desconto" class="form-control" disabled>
                    <div class="input-group-append">
                      <span class="input-group-text">%</span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <label for="preco_final">Preço Final:</label>
                  <input type="text" id="preco_final" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3">
                  <strong id="mensagem_erro" class="form-text text-danger" style="display: none;">* O desconto não pode ser maior que o preço!</strong>
                </div>
              </div>

              

              <input type="hidden" name="cadastrar" value="cadastrar_arte">
              <input type="submit" value="cadastrar" class="btn btn-primary mt-3">
            </form>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- JS SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="../../js/jquery.mask.js"></script>
  <script src="../../js/conta.js"></script>

</body>

</html>