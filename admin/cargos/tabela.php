<?php
//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';

//FILTROS
$status = $_POST['status'];
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
?>

<table class="table table-striped table-hover">

  <?php
  $sql = "SELECT * from cargo WHERE 1=1";

  //FILTRO POR STATUS
  if ($status != '') {
    $sql .= " AND cargo.status = $status";
  }
   if (!empty($nome)) {
    $sql .= " AND cargo.nome LIKE '%$nome%'";
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
        <th>Observação</th>
        <th>Status</th>
        <th>Data Cadastros</th>
        <th>Ações</th>

      </tr>
    </thead>

    <tbody>
      <?php
      //PARA CADA RETORNO DE LINHA QUE A MINHA VARIÁVEL TIVER TRANSFORME ELA PARA UM ARRAY ASSOCIATIVO - OU SEJA OS NOMES DAS COLUNAS 
      foreach ($query as $cargo) { //FECHAMENTO DEPOIS DO 'tr'
      ?>
        <tr>
          <!-- USANDO O ARRAY ASSOCIATIVO '$cargo['codigo_cargo]' ELE PEGA TODOS OS ITENS QUE TEM HAVER COM ESSA COLUNA -->
          <td><?php echo $cargo['codigo_cargo'] ?></td>
          <td><?php echo $cargo['nome'] ?></td>
          <td><?php echo $cargo['observacao'] ?></td>
          </td>

          <td>
            <?php
            if ($cargo['status'] == 1) {
              echo '<span class="badge badge-pill badge-success">Ativo</span>'; //BADGES DO BOOTSTRAP
            } else {
              echo '<span class="badge badge-pill badge-danger">Inativo</span>'; //BADGES DO BOOTSTRAP
            }
            ?>
          </td>

          <td><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])) ?></td> <!--ESSE 'strtotime' CONVERTE DATAS EM STRINGS-->

          <td>
            <a href="editar.php?codigo_cargo=<?php echo $cargo['codigo_cargo'] ?>" title="Editar" class="btn btn-outline-success btn-sm">
              <i class="bi bi-pencil"></i>
            </a>

            <!-- <a href="excluir.php?codigo_cargo=<?php echo $cargo['codigo_cargo'] ?>" title="Excluir" class="btn btn-outline-danger btn-sm">
              <i class="bi bi-trash"></i> -->
            <!-- </a> -->

            <form action ="acoes.php" method= "post" class ="d-inline"> 
              <button type="submit" title="Excluir" class="btn btn-outline-danger btn-sm" name="deletar" value=" <?php echo $cargo['codigo_cargo']?>" onclick="return confirm('Tem certeza que deseja excluir?')"> 
                <i class="bi bi-trash"></i>
              </button>
            </form>
            
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