<?php

//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';

 include_once '../usuario_admin.php';

?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>ArtConnect - Funcionários</title>

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
  <!-- ESSES '../../' ESTÁ DIZENDO PARA SAIR DA PASTA CARGOS E SAIR DA PASTA ADMIN E ACESSAR O CSS -->
  <link href="../../css/dashboard.css" rel="stylesheet">

  <!-- FAVICON -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>

<body>

  <?php
  #Início TOPO
  //ESSE '../' ESTÁ DIZENDO PARA SAIR DA PASTA CARGOS E PROCURAR O ARQUIVO TOPO
  include('../topo.php');
  #Final TOPO
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
      #Início MENU
      //ESSE '../' ESTÁ DIZENDO PARA SAIR DA PASTA CARGOS E PROCURAR O ARQUIVO TOPO
      include('../navegacao.php');
      #Final MENU
      ?>

      <main class="ml-auto col-lg-10 px-md-4">

        <div class="container mt-5">

                     <?php include '../mensagem.php' ?>
                     
          <div class="card">
            <div class="card-header d-flex justify-content-between aling-items-center">
              <h4 class="m-0">Funcionários</h4>

              <a href="inserir.php" class="btn btn-primary btn-sm">Adicionar</a>
            </div>

            <div class="row p-3">
              <!-- FILTRO POR SEXO -->
              <div class="col-lg-3">
                <select name="sexo" id="sexo" class="form-control" onchange="buscar()">
                  <option value="">Sexo</option>
                  <option value="F">Feminino</option>
                  <option value="M">Masculino</option>
                  <option value="N">Não Informado</option>
                </select>
              </div>

              <!-- FILTRO POR STATUS -->
              <div class="col-lg-2">
                <select name="status" id="status" class="form-control" onchange="buscar()">
                  <option value="">Status</option>
                  <option value="1">Ativo</option>
                  <option value="0">Inativo</option>
                </select>
              </div>

              <!-- FILTRO POR CARGO -->
              <div class="col-lg-3">
                <select name="cargo" id="cargo" class="form-control" onchange="buscar()">
                  <option value="">Cargo</option>

                  <?php
                  $sql_cargo = "SELECT  codigo_cargo, nome FROM cargo WHERE status = 1";
                  $query_cargo = mysqli_query($conexao, $sql_cargo);

                  foreach ($query_cargo as $cargo) {
                    echo '<option value="' . $cargo['codigo_cargo'] . '">' . $cargo['nome'] . '</option>'; //MOSTRE O 'codigo_cargo' E O 'nome' DO CARGO
                  }

                  ?>

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

  <?php
  mysqli_close($conexao) //FECHA A CONEXÃO COM O BANCO
  ?>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <!-- FITLROS -->
  <script>
    //  FUNÇÃO PARA LISTAR FUNCIONARIOS
    function listar(sexo, status, cargo, nome) {
      $("#listar").text('Carregando...');
      $.ajax({
        url: 'tabela.php',
        method: 'POST',
        data: {
          sexo,
          status,
          cargo,
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
      var gender = $('#sexo').val();
      var stts = $('#status').val();
      var role = $('#cargo').val();
      listar(gender, stts, role);
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