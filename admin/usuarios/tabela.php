<?php
//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';
//FILTROS
$status = $_POST['status'];
$sexo = $_POST['sexo'];
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$apelido = mysqli_real_escape_string($conexao, $_POST['apelido']);
?>
<table class="table table-striped table-hover">
  <?php
  $sql = "SELECT id, nome, apelido, sexo, data_cadastro, status FROM usuarios WHERE 1=1";

  if (!empty($sexo)) {
    $sql .= " AND usuarios.sexo = '$sexo'";
  }
  //FILTRO POR STATUS
  if ($status != '') {
    $sql .= " AND usuarios.status = $status";
  }
  if (!empty($nome)) {
    $sql .= " AND usuarios.nome LIKE '%$nome%'";
  }
  if (!empty($apelido)) {
    $sql .= " AND usuarios.apelido LIKE '%$apelido%'";
  }
  //ESSA QUERY (mysqli_query) ESTÁ DIZENDO O SEGUINTE - FAÇA CONEXÃO COM O BANCO ($conexao) E DEPOIS EXECUTE ESSA VARIÁVEL ($sql)
  $query = mysqli_query($conexao, $sql);

  if (mysqli_num_rows($query) > 0):
  ?>
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Apelido</th>
        <th>Sexo</th>
        <th>Data Cadastro</th>
        <th>Status</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($query as $usuarios): ?>
        <tr>
          <td><?= $usuarios['id'] ?></td>
          <td><?= $usuarios['nome'] ?></td>
          <td><?= $usuarios['apelido'] ?? '—' ?></td>
          <td><?= $usuarios['sexo'] ?></td>
          <td><?= date('d/m/Y', strtotime($usuarios['data_cadastro'])) ?></td>
          <td>
            <?php if ($usuarios['status']): ?>
              <span class="badge badge-success">Ativo</span>
            <?php else: ?>
              <span class="badge badge-danger">Inativo</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="editar.php?id=<?php echo $usuarios['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>
            <form action ="acoes.php" method= "post" class ="d-inline"> 
              <button type="submit" title="Excluir" class="btn btn-outline-danger btn-sm" name="deletar" value=" <?php echo $usuarios['id']?>" onclick="return confirm('Tem certeza que deseja excluir?')"> 
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  <?php else: ?>
    <p class="text-center mt-3">Nenhum usuário cadastrado.</p>
  <?php endif; ?>
</table>