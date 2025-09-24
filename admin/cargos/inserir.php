<?php
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
  <title>ArtConnect - Cargos</title>

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

          <!-- MENSAGEM -->
          <?php include '../mensagem.php' ?>

          <div class="card">
            <div class="card-header d-flex justify-content-between aling-items-center">
              <h4 class="m-0">Cargos</h4>

              <a href="index.php" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i>
                Voltar
              </a>
            </div>

            <div class="card-body">
              <form action="acoes.php" method="post">
                <div class="form-row mb-3">
                  <div class="col-6">
                    <label for="cargo"><strong class="text-danger">*</strong>Cargo:</label>
                    <input type="text" name="cargo" class="form-control" maxlength="40" required>
                  </div>

                  <div class="col-6">
                    <label for="status"><strong class="text-danger">*</strong>Status:</label>
                    <select name="status" class="form-control" disabled>
                      <option value="1" selected>Ativo</option>
                      <option value="0">Inativo</option>
                    </select>
                  </div>
                </div>

                <label for="observacao">Observação:</label>
                <textarea name="observacao" maxlength="100" class="form-control"></textarea>

                <input type="hidden" name="cadastrar" value="cadastrar_cargo"> <!--ESSE INPUT É UMA SEGURANÇA A MAIS PARA O CADASTRO - SE CHEGOU ESSE INPUT CADASTRE-->
                <input type="submit" value="Cadastrar" class="btn btn-primary mt-3">
              </form>
            </div>

          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- BOOTSTRAP JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>