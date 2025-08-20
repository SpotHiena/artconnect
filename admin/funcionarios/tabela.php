<?php
//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';

//FILTROS
$sexo = $_POST['sexo'];
$status = $_POST['status'];
$cargo = $_POST['cargo'];
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);

?>

<table class="table table-striped table-hover">

  <!-- COLOCAMOS ESSA TAG php ENTRE A 'table' E O 'thead' PORQUE QUEREMOS QUE CASO NÃO TENHA INFORMAÇÃO NO BANCO NÃO APAREÇA A TABELA MAS SIM O QUE DIZ ESSA TAG -->
  <?php
  $sql = "SELECT funcionario.codigo_funcionario, cargo.nome 'cargo', funcionario.nome, funcionario.telefone_celular, funcionario.status, funcionario.data_cadastro from funcionario INNER JOIN cargo on funcionario.codigo_cargo = cargo.codigo_cargo WHERE 1=1";

  // FILTRO POR SEXO
  if (!empty($sexo)) {
    $sql .= " AND funcionario.sexo = '$sexo'";
  }

  //FILTRO POR STATUS
  if ($status != '') {
    $sql .= " AND funcionario.status = $status";
  }
  if ($cargo != '') {
    $sql .= " AND funcionario.codigo_cargo = $cargo";
  }
  if (!empty($nome)) {
    $sql .= " AND funcionario.nome LIKE '%$nome%'";
  }

  //ESSA QUERY (mysqli_query) ESTÁ DIZENDO O SEGUINTE - FAÇA CONEXÃO COM O BANCO ($conexao) E DEPOIS EXECUTE ESSA VARIÁVEL ($sql)
  $query = mysqli_query($conexao, $sql);

  //ESSE 'if' DIZ QUE SE NÃO TIVER NADA NA TABELA NÃO MOSTRARÁ NADA
  if (mysqli_num_rows($query) > 0) { //ESSE 'if' FECHA DEPOIS DO 'tbody'
  ?>

    <thead>
      <tr>
        <th>#</th>
        <th>Cargo</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Status</th>
        <th>Data Cadastros</th>
        <th>Ações</th>

      </tr>
    </thead>

    <tbody>

      <?php
      //PARA CADA RETORNO DE LINHA QUE A MINHA VARIÁVEL TIVER TRANSFORME ELA PARA UM ARRAY ASSOCIATIVO - OU SEJA OS NOMES DAS COLUNAS 
      foreach ($query as $funcionario) { //FECHAMENTO DEPOIS DO 'tr'
      ?>

        <tr>
          <td><?php echo $funcionario['codigo_funcionario'] ?></td>
          <td><?php echo $funcionario['cargo'] ?></td>
          <td>
            <?php

            if ($funcionario['nome_social'] != "") {
              echo $funcionario['nome_social'];
            } else {
              echo $funcionario['nome'];
            }
            ?>
          </td>
          <td><?php echo $funcionario['telefone_celular'] ?></td>
          <td>
            <?php

            if ($funcionario['status'] == 1) {
              echo '<span class="badge badge-pill badge-success">Ativo</span>'; //BADGES DO BOOTSTRAP
            } else {
              echo '<span class="badge badge-pill badge-danger">Inativo</span>'; //BADGES DO BOOTSTRAP
            }
            ?>
          </td>

          <td><?php echo date('d/m/Y', strtotime($funcionario['data_cadastro'])) ?></td> <!--ESSE 'strtotime' CONVERTE DATAS EM STRINGS-->

          <td>
            <a href="editar.php?codigo_funcionario=<?php echo $funcionario['codigo_funcionario'] ?>" title="Editar" class="btn btn-outline-success btn-sm">
              <i class="bi bi-pencil"></i>
            </a>
             <form action ="acoes.php" method= "post" class ="d-inline"> 
              <button type="submit" title="Excluir" class="btn btn-outline-danger btn-sm" name="deletar" value=" <?php echo $funcionario['codigo_funcionario']?>" onclick="return confirm('Tem certeza que deseja excluir?')"> 
                <i class="bi bi-trash"></i>
              </button>
            </form>

            </a>
          </td>

        </tr>

      <?php

      }
      ?> <!--FECHAMENTO DA TAG 'php' ENTRE O tbody E O 'tr'-->

    </tbody>

  <?php
  } else {
    echo '<h5>Nenhum registro encontrado!</h5>';
  }
  ?> <!--FECHAMENTO DO 'if' DO 'php' ENTRE A 'table' E O 'thead'-->

</table>