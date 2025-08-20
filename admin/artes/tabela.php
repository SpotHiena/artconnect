<?php
require_once '../../conexao.php';


//FILTROS
$titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
$preco = $_POST['preco'];
$desconto = $_POST['desconto'];
$tags = $_POST['tags'];


$sql = "SELECT artes.*, usuarios.nome AS nome_artista, tags.nome AS lista_tags
        FROM artes LEFT JOIN usuarios ON artes.artista_id = usuarios.id LEFT JOIN arte_tag ON artes.id = arte_tag.arte_id LEFT JOIN tags ON tags.id = arte_tag.tag_id WHERE 1=1";


if ($preco != '') {
  $sql .= " AND artes.preco LIKE '%$preco%'";
}
if ($desconto != '') {
  $sql .= " AND artes.desconto = '$desconto'";
}
if ($tags != '') {
  $sql .= " AND tags.id = '$tags' AND tags.status = 1";
}
 if (!empty($titulo)) {
    $sql .= " AND artes.titulo LIKE '%$titulo%'";
  }


$sql .= " GROUP BY artes.id ORDER BY artes.id DESC";
function buscarTags($conexao, $arte_id)
{
  $tags = [];
  $sql = "SELECT tags.nome FROM tags 
            INNER JOIN arte_tag ON tags.id = arte_tag.tag_id 
            WHERE arte_tag.arte_id = $arte_id";
  $resultado = mysqli_query($conexao, $sql);
  while ($row = mysqli_fetch_assoc($resultado)) {
    $tags[] = $row['nome'];
  }
  return $tags;
}


$query = mysqli_query($conexao, $sql);
?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Imagem</th>
      <th>Título</th>
      <th>Preço</th>
      <th>Desconto (%)</th>
      <th>Preço com Desconto</th>
      <th>Tags</th>
      <th>Artista</th>
      <th>Publicação</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>

    <?php while ($linha = mysqli_fetch_assoc($query)) {

      $preco = $linha['preco'];
      $desconto = $linha['desconto'];
      $preco_final = $preco;

      if ($desconto > 0 && $desconto <= 100) {
        $preco_final = $preco - ($preco * ($desconto / 100));
      }

      $tags = buscarTags($conexao, $linha['id']);
    ?>
      <tr>
        <td>
          <img src="../../images/produtos/<?= $linha['imagem'] ?>" alt="Arte" style="height: 60px; width: auto;">
        </td>
        <td><?= htmlspecialchars($linha['titulo']) ?></td>
        <td>R$ <?= number_format($preco, 2, ',', '.') ?></td>
        <td><?= number_format($desconto, 0, '', '') ?>%</td>
        <td>R$ <?= number_format($preco_final, 2, ',', '.') ?></td>
        <td>
          <?php foreach ($tags as $tag): ?>
            <span class="badge badge-info"><?= htmlspecialchars($tag) ?></span>
          <?php endforeach; ?>
        </td>
        <td><?= htmlspecialchars($linha['nome_artista']) ?></td>
        <td><?= date('d/m/Y', strtotime($linha['data_publicacao'])) ?></td>
        <td>
        <td>
          <a href="editar.php?id=<?php echo $linha['id'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
              <i class="bi bi-pencil"></i>
            </a>

          <form action ="acoes.php" method= "post" class ="d-inline"> 
              <button type="submit" title="Excluir" class="btn btn-outline-danger btn-sm" name="deletar" value=" <?php echo $artes['id']?>" onclick="return confirm('Tem certeza que deseja excluir?')"> 
                <i class="bi bi-trash"></i>
              </button>
            </form>

          </a>
        </td>
        </a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>