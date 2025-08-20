<?php
require_once '../../conexao.php';

 include_once '../usuario_admin.php';

$sql = "SELECT a.*, u.nome AS nome_artista 
        FROM artes a 
        INNER JOIN usuarios u ON a.artista_id = u.id 
        ORDER BY a.data_publicacao DESC";
$resultado = mysqli_query($conexao, $sql);

function buscarTags($conexao, $arte_id)
{
  $sql = "SELECT t.nome FROM arte_tag at 
          INNER JOIN tags t ON at.tag_id = t.id 
          WHERE at.arte_id = $arte_id";
  $res = mysqli_query($conexao, $sql);
  $tags = [];
  while ($linha = mysqli_fetch_assoc($res)) {
    $tags[] = $linha['nome'];
  }
  return $tags;
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>ArtConnect - Artes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="../../css/dashboard.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>

<body>

  <?php include('../topo.php'); ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('../navegacao.php'); ?>
      <main class="ml-auto col-lg-10 px-md-4">

        <div class="container mt-5">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="m-0">Cadastrar Artes</h4>
              <a href="inserir.php" class="btn btn-primary btn-sm">Cadastrar Arte</a>
            </div>

            <div class="table-responsive">
              <div class="p-3 border-bottom bg-light">
                <div class="row">
                  <div class="col-lg-4">
                    <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquise por titulo...">
                  </div>
                  <div class="col-md-2 mb-2">
                    <input type="number" id="preco" class="form-control" placeholder="Preço" onchange="buscar()">
                  </div>
                  <div class="col-md-2 mb-2">
                    <input type="number" id="desconto" class="form-control" placeholder="Desconto (%)" onchange="buscar()">
                  </div>
                  <div class="col-md-3 mb-2">
                    <select id="tags" class="form-control" onchange="buscar()">
                      <option value="">Tags</option>
                      <?php
                      $res = mysqli_query($conexao, "SELECT id, nome FROM tags WHERE status = 1 ORDER BY nome ASC");
                      while ($tag = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$tag['id']}'>{$tag['nome']}</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div id="listar"></div>
              </div>
            </div>
          </div>
          

      </main>
    </div>
  </div>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script>
    //  FUNÇÃO PARA LISTAR FUNCIONARIOS
    function listar(preco, desconto, tags, titulo) {
      $("#listar").text('Carregando...');
      $.ajax({
        url: 'tabela.php',
        method: 'POST',
        data: {
          preco,
          desconto,
          tags,
          titulo
        },
        dataType: 'html',
        success: function(res) {
          $('#listar').html(res);
        }
      })
    }
    // FUNÇÃO PARA BUSCAR FILTRAR
    function buscar() {
      var price = $('#preco').val();
      var discount = $('#desconto').val();
      var categoria = $('#tags').val();
      listar(price, discount, categoria);
    }
    $(document).ready(function() {
      listar();
      //FUNÇÃO PRA BUSCAR POR NOME

      $('#pesquisa').keyup(function() {
        var pesquisa = $(this).val();
        listar('', '', '', pesquisa);
      })
    })
  </script>

</body>

</html>