<?php
require_once '../../conexao.php';
 include_once '../usuario_admin.php';

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Art Connect - Tags</title>

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- CUSTOM CSS -->
  <link href="../../css/dashboard.css" rel="stylesheet">

  <!-- FAVICON -->
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
              <h4 class="m-0">Tags</h4>
              <a href="inserir.php" class="btn btn-primary btn-sm">Adicionar Tags</a>
            </div>

            <div class="card-body">
              <div class="row p-3">
                <!-- FILTRO POR STATUS -->
                <div class="col-lg-2">
                  <select name="status" id="status" class="form-control" onchange="buscar()">
                    <option value="">Status</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>

                <div class="col-lg-4">
                  <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquise por nome...">
                </div>
              </div>
              <!-- TABELA DE REGISTRO -->
              <div id="listar"></div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <?php mysqli_close($conexao); ?>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <script>
    //  FUNÇÃO PARA LISTAR FUNCIONARIOS
    function listar(status, nome) {
      $("#listar").text('Carregando...');
      $.ajax({
        url: 'tabela.php',
        method: 'POST',
        data: {
          status,
          nome
        },
        dataType: 'html',
        success: function(res) {
          $('#listar').html(res);
        }
      })
    }
    // FUNÇÃO PARA BUSCAR FILTRAR
    function buscar() {
      var stts = $('#status').val();
      var role = $('#nome').val();
      listar(stts, role);
    }
    $(document).ready(function() {
      listar();
      $('#pesquisa').keyup(function() {
        var pesquisa = $(this).val();
        listar('', pesquisa);
      })
    })
  </script>

</body>

</html>