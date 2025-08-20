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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

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

                    <?php //<- PHP 'LA EM CIMA '
                    if (isset($_GET['codigo_funcionario']) && $_GET['codigo_funcionario'] != '') {
                        $codigo = $_GET['codigo_funcionario'];
                        $sql = "SELECT * FROM funcionario WHERE codigo_funcionario = $codigo";
                        $query = mysqli_query($conexao, $sql);
                        $funcionario = mysqli_fetch_assoc($query);
                    ?>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between aling-items-center">
                                <h4 class="m-0">Editar Funcionário</h4>

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
                                                        ?>

                                                            <option value="<?php echo $cargo['codigo_cargo'] ?>" <?php if ($funcionario['codigo_cargo'] == $cargo['codigo_cargo'])
                                                                                                                        echo 'selected' ?>><?php echo $cargo['nome'] ?></option>

                                                        <?php
                                                        } while ($cargo = mysqli_fetch_assoc($query_cargo));

                                                        ?>

                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    <label for="salario">Salário:</label>
                                                    <input type="text" name="salario" class="form-control" id="salario"
                                                        data-mask="000000,00" data-mask-reverse="true"
                                                        value="<?php echo $funcionario['salario'] ?>" required>
                                                </div>

                                                <div class="col-4">
                                                    <label for="status"><strong
                                                            class="text-danger">*</strong>Status:</label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="0" <?php if ($funcionario['status'] == 0)
                                                                                echo 'selected' ?>>Inativo</option>
                                                        <option value="1" <?php if ($funcionario['status'] == 1)
                                                                                echo 'selected' ?>>Ativo</option>
                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <label for="nome"><strong class="text-danger">*</strong>Nome:</label>
                                                    <input type="text" name="nome" id="nome" class="form-control"
                                                        maxlength="60" value="<?php echo $funcionario['nome'] ?>" required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="nome_social">Nome Social:</label>
                                                    <input type="text" name="nome_social" id="nome_social"
                                                        class="form-control" maxlength="60"
                                                        value="<?php echo $funcionario['nome_social'] ?>" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-2">
                                            <img id="preview"
                                                src="<?php echo ($funcionario['foto']) ?>" alt="foto" width="100px" height="100px">
                                            <input type="hidden" name="foto_atual"
                                                value="<?php echo $funcionario['foto']; ?>">
                                            <input type="file" name="foto" id="foto" class="form-control-file mb-2" accept="image/*">
                                        </div>


                                        <div class="col-2">
                                            <label for="data_nascimento"><strong class="text-danger">*</strong>Data
                                                Nascimento:</label>
                                            <input type="date" name="data_nascimento" id="data_nascimento"
                                                class="form-control" maxlength="40"
                                                value="<?php echo $funcionario['data_nascimento'] ?>" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="sexo"><strong class="text-danger">*</strong>Sexo:</label>
                                            <select name="sexo" id="sexo" class="form-control">
                                                <option value=""></option>
                                                <option value="masculino" <?php if ($funcionario['sexo'] == 'm')
                                                                                echo 'selected'; ?>>Masculino</option>
                                                <option value="feminino" <?php if ($funcionario['sexo'] == 'f')
                                                                                echo 'selected'; ?>>Feminino</option>
                                                <option value="nao_informado" <?php if ($funcionario['sexo'] == 'n')
                                                                                    echo 'selected'; ?>>Não Informado</option>
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <label for="cpf"><strong class="text-danger">*</strong>CPF:</label>
                                            <input type="text" name="cpf" class="form-control" maxlength="14" id="rg"
                                                data-mask="000.000.000-00" value="<?php echo $funcionario['cpf'] ?>"
                                                required>
                                        </div>

                                        <div class="col-2">
                                            <label for="rg">RG:</label>
                                            <input type="text" name="rg" class="form-control" data-mask="00.000.000-A"
                                                id="rg" maxlength="12" value="<?php echo $funcionario['rg'] ?>" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="estado_civil">Estado Civil:</label>
                                            <select name="estado_civil" id="estado_civil" class="form-control">
                                                <option value="solteiro" <?php if ($funcionario['estado_civil'] == 'solteiro')
                                                                                echo 'selected' ?>>Solteiro(a)</option>
                                                <option value="casado" <?php if ($funcionario['estado_civil'] == 'casado')
                                                                            echo 'selected' ?>>Casado</option>
                                                <option value="divorciado" <?php if ($funcionario['estado_civil'] == 'divorciado')
                                                                                echo 'selected' ?>>
                                                    Divorciado</option>
                                                <option value="separado" <?php if ($funcionario['estado_civil'] == 'separado')
                                                                                echo 'selected' ?>>Separado</option>
                                                <option value="viuvo" <?php if ($funcionario['estado_civil'] == 'viuvo')
                                                                            echo 'selected' ?>>Viúvo</option>
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <label for="email"><strong class="text-danger">*</strong>E-mail:</label>
                                            <input type="email" name="email" class="form-control" maxlength="50" id="email"
                                                value="<?php echo $funcionario['email'] ?>" required>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <h6>Endereço:</h6>
                                        </div>

                                        <div class="col-2">
                                            <label for="cep"><strong class="text-danger">*</strong>CEP:</label>
                                            <input type="text" name="cep" class="form-control" maxlength="9" id="cep"
                                                data-mask="00000-000" value="<?php echo $funcionario['cep'] ?>" required>
                                        </div>

                                        <div class="col-6">
                                            <label for="endereco"><strong class="text-danger">*</strong>Endereço:</label>
                                            <input type="text" name="endereco" id="endereco" class="form-control"
                                                maxlength="70" value="<?php echo $funcionario['endereco'] ?>" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="numero"><strong class="text-danger">*</strong>Número:</label>
                                            <input type="text" name="numero" id="numero" class="form-control" maxlength="4"
                                                value="<?php echo $funcionario['numero'] ?>" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="complemento"><strong
                                                    class="text-danger">*</strong>Complemento:</label>
                                            <input type="text" name="complemento" id="complemento" class="form-control"
                                                maxlength="40" value="<?php echo $funcionario['complemento'] ?>" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="bairro"><strong class="text-danger">*</strong>Bairro:</label>
                                            <input type="text" name="bairro" id="bairro" class="form-control" maxlength="30"
                                                value="<?php echo $funcionario['bairro'] ?>" required>
                                        </div>

                                        <div class="col-6">
                                            <label for="cidade"><strong class="text-danger">*</strong>Cidade:</label>
                                            <input type="text" name="cidade" id="cidade" class="form-control" maxlength="40"
                                                value="<?php echo $funcionario['cidade'] ?>" required>
                                        </div>

                                        <div class="col-4">
                                            <label for="estado"><strong class="text-danger">*</strong>Estado:</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value=""></option>
                                                <option value="AC" <?php if ($funcionario['estado'] == 'AC')
                                                                        echo 'selected'; ?>>AC</option>
                                                <option value="AL" <?php if ($funcionario['estado'] == 'AL')
                                                                        echo 'selected'; ?>>AL</option>
                                                <option value="AP" <?php if ($funcionario['estado'] == 'AP')
                                                                        echo 'selected'; ?>>AP</option>
                                                <option value="AM" <?php if ($funcionario['estado'] == 'AM')
                                                                        echo 'selected'; ?>>AM</option>
                                                <option value="BA" <?php if ($funcionario['estado'] == 'BA')
                                                                        echo 'selected'; ?>>BA</option>
                                                <option value="CE" <?php if ($funcionario['estado'] == 'CE')
                                                                        echo 'selected'; ?>>CE</option>
                                                <option value="DF" <?php if ($funcionario['estado'] == 'DF')
                                                                        echo 'selected'; ?>>DF</option>
                                                <option value="ES" <?php if ($funcionario['estado'] == 'ES')
                                                                        echo 'selected'; ?>>ES</option>
                                                <option value="GO" <?php if ($funcionario['estado'] == 'GO')
                                                                        echo 'selected'; ?>>GO</option>
                                                <option value="MA" <?php if ($funcionario['estado'] == 'MA')
                                                                        echo 'selected'; ?>>MA</option>
                                                <option value="MT" <?php if ($funcionario['estado'] == 'MT')
                                                                        echo 'selected'; ?>>MT</option>
                                                <option value="MS" <?php if ($funcionario['estado'] == 'MS')
                                                                        echo 'selected'; ?>>MS</option>
                                                <option value="MG" <?php if ($funcionario['estado'] == 'MG')
                                                                        echo 'selected'; ?>>MG</option>
                                                <option value="PA" <?php if ($funcionario['estado'] == 'PA')
                                                                        echo 'selected'; ?>>PA</option>
                                                <option value="PB" <?php if ($funcionario['estado'] == 'PB')
                                                                        echo 'selected'; ?>>PB</option>
                                                <option value="PR" <?php if ($funcionario['estado'] == 'PR')
                                                                        echo 'selected'; ?>>PR</option>
                                                <option value="PE" <?php if ($funcionario['estado'] == 'PE')
                                                                        echo 'selected'; ?>>PE</option>
                                                <option value="PI" <?php if ($funcionario['estado'] == 'PI')
                                                                        echo 'selected'; ?>>PI</option>
                                                <option value="RJ" <?php if ($funcionario['estado'] == 'RJ')
                                                                        echo 'selected'; ?>>RJ</option>
                                                <option value="RN" <?php if ($funcionario['estado'] == 'RN')
                                                                        echo 'selected'; ?>>RN</option>
                                                <option value="RS" <?php if ($funcionario['estado'] == 'RS')
                                                                        echo 'selected'; ?>>RS</option>
                                                <option value="RO" <?php if ($funcionario['estado'] == 'RO')
                                                                        echo 'selected'; ?>>RO</option>
                                                <option value="RR" <?php if ($funcionario['estado'] == 'RR')
                                                                        echo 'selected'; ?>>RR</option>
                                                <option value="SC" <?php if ($funcionario['estado'] == 'SC')
                                                                        echo 'selected'; ?>>SC</option>
                                                <option value="SP" <?php if ($funcionario['estado'] == 'SP')
                                                                        echo 'selected'; ?>>SP</option>
                                                <option value="SE" <?php if ($funcionario['estado'] == 'SE')
                                                                        echo 'selected'; ?>>SE</option>
                                                <option value="TO" <?php if ($funcionario['estado'] == 'TO')
                                                                        echo 'selected'; ?>>TO</option>

                                            </select>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <h6>Contato:</h6>
                                        </div>

                                        <div class="col-6">
                                            <label for="telefone_residencial">Telefone Residencial:</label>
                                            <input type="text" name="telefone_residencial" id="telefone_residencial"
                                                class="form-control" data-mask="(00) 0000-0000"
                                                value="<?php echo $funcionario['telefone_residencial'] ?>" maxlength="15">
                                        </div>

                                        <div class="col-6">
                                            <label for="telefone_celular"><strong
                                                    class="text-danger">*</strong>Celular:</label>
                                            <input type="text" name="telefone_celular" id="telefone_celular"
                                                class="form-control" maxlength="17" data-mask="(00) 00000-0000"
                                                value="<?php echo $funcionario['telefone_celular'] ?>" required>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <h6>Acesso:</h6>
                                        </div>

                                        <div class="col-4">
                                            <label for="tipo_acesso"><strong class="text-danger">*</strong>Tipo
                                                Acesso:</label>
                                            <select name="tipo_acesso" id="tipo_acesso" class="form-control">
                                                <option value=""></option>
                                                <option value="1" <?php if ($funcionario['tipo_acesso'] == '1')
                                                                        echo 'selected'; ?>>Admin</option>
                                                <option value="0" <?php if ($funcionario['tipo_acesso'] == '0')
                                                                        echo 'selected'; ?>>Comum</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="usuario"><strong class="text-danger">*</strong>Usuário:</label>
                                            <input type="text" name="usuario" id="usuario" class="form-control"
                                                maxlength="20" value="<?php echo $funcionario['usuario'] ?>" required>
                                        </div>

                                        <div class="col-4">
                                            <label for="senha"><strong class="text-danger">*</strong>Senha:</label>
                                            <input type="text" name="senha" id="senha" class="form-control" maxlength="8"
                                                value="<?php echo $funcionario['senha'] ?>" required>
                                        </div>

                                    </div>
                                    <input type="hidden" name="atualizar" value="atualizar_funcionario">
                                    <input type="hidden" name="codigo_funcionario" value="<?php echo $codigo ?>">
                                    <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                                </form>
                            </div>

                        </div>

                    <?php
                    } //<- SERVE PRA FECHAR O IF DO PHP LA EM CIMA
                    else {
                        echo "<h5>Funcionario não encontrado<h5>";
                    }
                    ?>
                </div>

            </main>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <!-- JQRY MASK - TEM QUE SER DPS DO BOOTSTRAP JQUERY SE NAO NAO VAI FUNCIONCAR -->

    <script src="../../js/jquery.mask.js"></script>
    <!-- JQRY DO CEP -->
    <script src="../../js/script.js"></script>

    <script src="../../js/imagem.js"></script>

</body>

</html>