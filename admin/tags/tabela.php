<?php
//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';

//FILTROS
$status = $_POST['status'];
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
?>

<table class="table table-striped table-hover">

  <?php
  $sql = "SELECT * FROM tags WHERE 1=1";

  //FILTRO POR STATUS
  if ($status != '') {
    $sql .= " AND tags.status = $status";
  }
  if (!empty($nome)) {
    $sql .= " AND tags.nome LIKE '%$nome%'";
  }

  //ESSA QUERY (mysqli_query) ESTÁ DIZENDO O SEGUINTE - FAÇA CONEXÃO COM O BANCO ($conexao) E DEPOIS EXECUTE ESSA VARIÁVEL ($sql)
  $query = mysqli_query($conexao, $sql);

  //ESSE 'if' DIZ QUE SE NÃO TIVER NADA NA TABELA NÃO MOSTRARÁ NADA
  if (mysqli_num_rows($query) > 0) { //ESSE 'if' FECHA DEPOIS DO 'tbody'
  ?>
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Status</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($query as $tags) { ?>
        <tr>
          <td><?php echo $tags['id'] ?></td>
          <td><?php echo $tags['nome'] ?></td>
          <td>
            <?php

            if ($tags['status'] == 1) {
              echo '<span class="badge badge-pill badge-success">Ativo</span>'; //BADGES DO BOOTSTRAP
            } else {
              echo '<span class="badge badge-pill badge-danger">Inativo</span>'; //BADGES DO BOOTSTRAP
            }
            ?>
          </td>
          <td>
            <a href="editar.php?id=<?php echo $tags['id'] ?>" title="Editar" class="btn btn-outline-success btn-sm">
              <i class="bi bi-pencil"></i>
            </a>
            <form action ="acoes.php" method= "post" class ="d-inline"> 
              <button type="submit" title="Excluir" class="btn btn-outline-danger btn-sm" name="deletar" value=" <?php echo $tags['id']?>" onclick="return confirm('Tem certeza que deseja excluir?')"> 
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  <?php
  } else {
    echo '<h5>Nenhuma tag cadastrada!</h5>';
  }
  ?>
</table>