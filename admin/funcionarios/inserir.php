<?php
//CONEXAO COOM O BANCO DE DADOS
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

              <a href="index.php" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i>
                Voltar
              </a>
            </div>

            <div class="card-body">
              <form action="acoes.php" method="post" enctype="multipart/form-data">

                <h6>Dados Pessoais:</h6>

                <div class="form-row">
                  <div class="col-10">
                    <div class="form-row mb-3">
                      <div class="col-4">
                        <label for="cargo"><strong class="text-danger">*</strong>Cargo:</label>
                        <select name="cargo" class="form-control" required>
                          <option value="">- Selecione -</option>

                          <?php

                          $sql_cargo = 'SELECT codigo_cargo, nome FROM cargo WHERE status = 1';
                          $query_cargo = mysqli_query($conexao, $sql_cargo);
                          $cargo = mysqli_fetch_assoc($query_cargo);

                          do {
                            echo '<option value="' . $cargo['codigo_cargo'] . '">' . $cargo['nome'] . '</option>';
                          } while ($cargo = mysqli_fetch_assoc($query_cargo));

                          ?>



                        </select>
                      </div>

                      <div class="col-4">
                        <label for="salario">Salário:</label>
                        <input type="text" name="salario" class="form-control" id="salario" data-mask="000000,00" data-mask-reverse="true" required>
                      </div>

                      <div class="col-4">
                        <label for="status"><strong class="text-danger">*</strong>Status:</label>
                        <select name="status" class="form-control" id="status" disabled>
                          <option value="0" selected>Ativo</option>
                          <option value="1">Inativo</option>
                        </select>
                      </div>

                      <div class="col-6">
                        <label for="nome"><strong class="text-danger">*</strong>Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" maxlength="60" required>
                      </div>

                      <div class="col-6">
                        <label for="nome_social">Nome Social:</label>
                        <input type="text" name="nome_social" id="nome_social" class="form-control" maxlength="60" required>
                      </div>
                    </div>
                  </div>


                  <div class="col-2">
                    <img id="preview" src="../../assets/img/funcionario.avif" alt="foto" width="100px" height="100px">
                    <input type="file" name="foto" id="foto" class="form-control-file mb-2" accept="image/*">
                  </div>

                  <div class="col-2">
                    <label for="data_nascimento"><strong class="text-danger">*</strong>Data Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" maxlength="40" required>
                  </div>

                  <div class="col-2">
                    <label for="sexo"><strong class="text-danger">*</strong>Sexo:</label>
                    <select name="sexo" id="sexo" class="form-control">
                      <option value=""></option>
                      <option value="masculino">Masculino</option>
                      <option value="feminino">Feminino</option>
                      <option value="nao_informado">Não Informado</option>
                    </select>
                  </div>

                  <div class="col-2">
                    <label for="cpf"><strong class="text-danger">*</strong>CPF:</label>
                    <input type="text" name="cpf" class="form-control" maxlength="14" id="rg" data-mask="000.000.000-00" required>
                  </div>

                  <div class="col-2">
                    <label for="rg">RG:</label>
                    <input type="text" name="rg" class="form-control" data-mask="00.000.000-A" id="rg" maxlength="12" required>
                  </div>

                  <div class="col-2">
                    <label for="estado_civil">Estado Civil:</label>
                    <select name="estado_civil" id="estado_civil" class="form-control">
                      <option value="solteiro">Solteiro(a)</option>
                      <option value="casado">Casado</option>
                      <option value="divorciado">Divorciado</option>
                      <option value="separado">Separado</option>
                      <option value="viuvo">Viúvo</option>
                    </select>
                  </div>

                  <div class="col-2">
                    <label for="email"><strong class="text-danger">*</strong>E-mail:</label>
                    <input type="email" name="email" class="form-control" maxlength="50" id="email" required>
                  </div>

                  <div class="col-12 mt-2">
                    <h6>Endereço:</h6>
                  </div>

                  <div class="col-2">
                    <label for="cep"><strong class="text-danger">*</strong>CEP:</label>
                    <input type="text" name="cep" class="form-control" maxlength="9" id="cep" data-mask="00000-000" required>
                  </div>

                  <div class="col-6">
                    <label for="endereco"><strong class="text-danger">*</strong>Endereço:</label>
                    <input type="text" name="endereco" id="endereco" class="form-control" maxlength="70" required>
                  </div>

                  <div class="col-2">
                    <label for="numero"><strong class="text-danger">*</strong>Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control" maxlength="4" required>
                  </div>

                  <div class="col-2">
                    <label for="complemento"><strong class="text-danger">*</strong>Complemento:</label>
                    <input type="text" name="complemento" id="complemento" class="form-control" maxlength="40" required>
                  </div>

                  <div class="col-2">
                    <label for="bairro"><strong class="text-danger">*</strong>Bairro:</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" maxlength="30" required>
                  </div>

                  <div class="col-6">
                    <label for="cidade"><strong class="text-danger">*</strong>Cidade:</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" maxlength="40" required>
                  </div>

                  <div class="col-4">
                    <label for="estado"><strong class="text-danger">*</strong>Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                      <option value=""></option>
                      <option value="AC">AC</option>
                      <option value="AL">AL</option>
                      <option value="AP">AP</option>
                      <option value="AM">AM</option>
                      <option value="BA">BA</option>
                      <option value="CE">CE</option>
                      <option value="DF">DF</option>
                      <option value="ES">ES</option>
                      <option value="GO">GO</option>
                      <option value="MA">MA</option>
                      <option value="MT">MT</option>
                      <option value="MS">MS</option>
                      <option value="MG">MG</option>
                      <option value="PA">PA</option>
                      <option value="PB">PB</option>
                      <option value="PR">PR</option>
                      <option value="PE">PE</option>
                      <option value="PI">PI</option>
                      <option value="RJ">RJ</option>
                      <option value="RN">RN</option>
                      <option value="RS">RS</option>
                      <option value="RO">RO</option>
                      <option value="RR">RR</option>
                      <option value="SC">SC</option>
                      <option value="SP">SP</option>
                      <option value="SE">SE</option>
                      <option value="TO">TO</option>
                    </select>
                  </div>

                  <div class="col-12 mt-2">
                    <h6>Contato:</h6>
                  </div>

                  <div class="col-6">
                    <label for="telefone_residencial">Telefone Residencial:</label>
                    <input type="text" name="telefone_residencial" id="telefone_residencial" class="form-control" data-mask="(00) 0000-0000" maxlength="15">
                  </div>

                  <div class="col-6">
                    <label for="telefone_celular"><strong class="text-danger">*</strong>Celular:</label>
                    <input type="text" name="telefone_celular" id="telefone_celular" class="form-control" maxlength="17" data-mask="(00) 00000-0000" required>
                  </div>

                  <div class="col-12 mt-2">
                    <h6>Acesso:</h6>
                  </div>

                  <div class="col-4">
                    <label for="tipo_acesso"><strong class="text-danger">*</strong>Tipo Acesso:</label>
                    <select name="tipo_acesso" id="tipo_acesso" class="form-control">
                      <option value=""></option>
                      <option value="1">Admin</option>
                      <option value="0">Comum</option>
                    </select>
                  </div>

                  <div class="col-4">
                    <label for="usuario"><strong class="text-danger">*</strong>Usuário:</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" maxlength="20" required>
                  </div>

                  <div class="col-4">
                    <label for="senha"><strong class="text-danger">*</strong>Senha:</label>
                    <input type="text" name="senha" id="senha" class="form-control" maxlength="8" required>
                  </div>

                </div>
                <input type="hidden" name="cadastrar" value="cadastrar_funcionario">
                <input type="submit" value="Cadastrar" class="btn btn-primary mt-3">
              </form>
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

  <!-- JQRY MASK - TEM QUE SER DPS DO BOOTSTRAP JQUERY SE NAO NAO VAI FUNCIONCAR -->

  <script src="../../js/jquery.mask.js"></script>
  <!-- JQRY DO CEP -->
  <script src="../../js/script.js"></script>

  <script src="../../js/imagem.js"></script>

</body>

</html>