<?php
require_once '../../conexao.php';

 include_once '../usuario_admin.php';
 
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

  <style>
    .foto-perfil {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      padding-top: 0;
      margin-top: -5px;
    }

    .foto-perfil img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      margin-bottom: 5px;
    }

    .foto-perfil input[type="file"] {
      width: auto;
    }
  </style>
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

          <?php
          if (isset($_GET['id']) && $_GET['id'] != '') {
            $codigo = $_GET['id'];
            $sql = "SELECT * FROM usuarios WHERE id = $codigo";
            $query = mysqli_query($conexao, $sql);
            $usuarios = mysqli_fetch_assoc($query);
          ?>

            <div class="card-body">
              <form action="acoes.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-9">
                    <div class="form-row mb-3">
                      <div class="col-3">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $usuarios['nome'] ?>" required>
                      </div>
                      <div class="col-md-3">
                        <label for="nome_social">Nome Social:</label>
                        <input type="text" name="nome_social" class="form-control" value="<?php echo $usuarios['nome_social'] ?>">
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-m3">
                        <label for="apelido">Apelido:</label>
                        <input type="text" name="apelido" class="form-control" maxlength="20" value="<?php echo $usuarios['apelido'] ?>">
                      </div>
                      <div class="col-3">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $usuarios['email'] ?>" required>
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-2">
                        <label for="senha">Senha:</label>
                        <input type="text" name="senha" class="form-control" value="<?php echo $usuarios['senha'] ?>" required>
                      </div>
                      <div class="col-2">
                        <label for="tipo">Tipo:</label>
                        <select name="tipo" class="form-control" required>
                          <option value="">- Selecione -</option>
                          <option value="1" <?php if ($usuarios['tipo_acesso'] == 1) echo 'selected' ?>>Admin</option>
                          <option value="0" <?php if ($usuarios['tipo_acesso'] == 0) echo 'selected' ?>>Comum</option>
                        </select>
                      </div>
                      <div class="col-2">
                        <label for="sexo"><strong class="text-danger">*</strong>Sexo:</label>
                        <select name="sexo" id="sexo" class="form-control">
                          <option value=""></option>
                          <option value="M" <?php if ($usuarios['sexo'] == 'M') echo 'selected' ?>>Masculino</option>
                          <option value="F" <?php if ($usuarios['sexo'] == 'F') echo 'selected' ?>>Feminino</option>
                          <option value="N" <?php if ($usuarios['sexo'] == 'N') echo 'selected' ?>>Não Informado</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-2">
                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" class="form-control" data-mask="000.000.000-00" value="<?php echo $usuarios['cpf'] ?>" required>
                      </div>
                      <div class="col-2">
                        <label for="rg">RG:</label>
                        <input type="text" name="rg" class="form-control" data-mask="00.000.000-A" value="<?php echo $usuarios['rg'] ?>" required>
                      </div>
                      <div class="col-2">
                        <label for="data_nascimento">Data de Nascimento:</label>
                        <input type="date" name="data_nascimento" class="form-control" value="<?php echo $usuarios['data_nascimento'] ?>" required>
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-2">
                        <label for="status"><strong class="text-danger">*</strong>Status:</label>
                        <select name="status" class="form-control" id="status">
                          <option value="1" <?php if ($usuarios['status'] == 1) echo 'selected' ?>>Ativo</option>
                          <option value="0" <?php if ($usuarios['status'] == 0) echo 'selected' ?>>Inativo</option>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="data_cadastro" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="atualizar" value="atualizar_usuario">
                    <input type="hidden" name="id" value="<?php echo $codigo ?>">
                    <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                  </div>

                  <div class="col-md-3 foto-perfil">
                    <img id="preview" src="../../assets/img/funcionario.avif" alt="foto">
                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                  </div>
                </div>
              </form>
            </div>
          <?php
          } else {
            echo "<h5>Usuario não encontrado<h5>";
          }
          ?>

          <!-- JS -->
          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
          <script src="../../js/jquery.mask.js"></script>
          <script src="../../js/script.js"></script>
          <script src="../../js/imagem.js"></script>

</body>

</html>
