<?php
require_once '../../conexao.php';
if (!isset($_SESSION)) {
  session_start();
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>Cadastro de Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="../../css/dashboard.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico">
</head>

<body>

  <?php include('../topo.php'); ?>

  <div class="container-fluid">
    <div class="row">
      <?php include('../navegacao.php'); ?>

      <main class="ml-auto col-lg-10 px-md-4 mt-5">
        <div class="card">
          <?php include '../mensagem.php'; ?>
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0">Cadastro de Usuário</h4>
            <a href="index.php" class="btn btn-primary btn-sm">
              <i class="bi bi-arrow-left"></i> Voltar
            </a>
          </div>

          <div class="card-body">
            <form action="acoes.php" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-row mb-3">
                    <div class="col-3">
                      <label for="nome">Nome:</label>
                      <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                      <label for="nome_social">Nome Social:</label>
                      <input type="text" name="nome_social" class="form-control">
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-m3">
                      <label for="apelido">Apelido:</label>
                      <input type="text" name="apelido" class="form-control" maxlength="20">
                    </div>
                    <div class="col-3">
                      <label for="email">Email:</label>
                      <input type="email" name="email" class="form-control" required>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-2">
                      <label for="senha">Senha:</label>
                      <input type="password" name="senha" class="form-control" required>
                    </div>
                    <div class="col-2">
                      <label for="tipo">Tipo:</label>
                      <select name="tipo" class="form-control" required>
                        <option value="">- Selecione -</option>
                        <option value="1">Admin</option>
                        <option value="0">Comum</option>
                      </select>
                    </div>
                    <div class="col-2">
                      <label for="sexo"><strong class="text-danger">*</strong>Sexo:</label>
                      <select name="sexo" id="sexo" class="form-control">
                        <option value=""></option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="N">Não Informado</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row mb-3">
                    <div class="col-2">
                      <label for="cpf">CPF:</label>
                      <input type="text" name="cpf" class="form-control" data-mask="000.000.000-00" required>
                    </div>
                    <div class="col-2">
                      <label for="rg">RG:</label>
                      <input type="text" name="rg" class="form-control" data-mask="00.000.000-A" required>
                    </div>
                    <div class="col-2">
                      <label for="data_nascimento">Data de Nascimento:</label>
                      <input type="date" name="data_nascimento" class="form-control" required>
                    </div>
                  </div>



                  <div class="form-row mb-3">
                    <div class="col-2">
                      <label for="status"><strong class="text-danger">*</strong>Status:</label>
                      <select name="status" class="form-control" id="status" disabled>
                        <option value="1" selected>Ativo</option>
                        <option value="0">Inativo</option>
                      </select>
                    </div>
                  </div>

                  <input type="hidden" name="data_cadastro" value="<?php echo date('Y-m-d'); ?>">
                  <input type="hidden" name="cadastrar" value="cadastrar_usuario">
                  <input type="submit" value="Cadastrar" class="btn btn-primary mt-3">
                </div>
                <div class="form-row mb-3">
                  <div class="col-2">
                    <img id="preview" src="../../assets/img/funcionario.avif" alt="foto" width="100px" height="100px">
                    <input type="file" name="foto" id="foto" class="form-control-file mb-2" accept="image/*">
                  </div>
                </div>
            </form>
          </div>

          <!-- JS -->
          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
          <!-- JQRY MASK - TEM QUE SER DPS DO BOOTSTRAP JQUERY SE NAO NAO VAI FUNCIONCAR -->

          <script src="../../js/jquery.mask.js"></script>
          <!-- JQRY DO CEP -->
          <script src="../../js/script.js"></script>
          <script src="../../js/imagem.js"></script>


</body>

</html>