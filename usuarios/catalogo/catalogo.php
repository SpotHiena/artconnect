<?php
session_start();
require_once '../../conexao.php';

// PEGAR FILTROS
$pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conexao, $_GET['pesquisa']) : "";
$preco = isset($_GET['preco']) && $_GET['preco'] !== '' ? floatval($_GET['preco']) : null;
$promocao = isset($_GET['filtro-promocao']) ? $_GET['filtro-promocao'] : "";
$desconto = isset($_GET['desconto']) && $_GET['desconto'] !== '' ? floatval($_GET['desconto']) : null;
$tagId = isset($_GET['tags']) && $_GET['tags'] !== '' ? intval($_GET['tags']) : null;

// Montar filtro extra
$filtros = [];
if ($pesquisa !== "") {
  $filtros[] = "artes.titulo LIKE '%$pesquisa%'";
}
if ($preco !== null) {
  $filtros[] = "artes.preco <= $preco";
}
if ($promocao === "sim") {
  $filtros[] = "artes.desconto > 0";
} elseif ($promocao === "nao") {
  $filtros[] = "artes.desconto = 0";
}
if ($desconto !== null) {
  $filtros[] = "artes.desconto >= $desconto";
}

$sqlTagJoin = "";
if ($tagId !== null) {
  $sqlTagJoin = "INNER JOIN arte_tag at ON artes.id = at.arte_id AND at.tag_id = $tagId";
}

// Montar filtro SQL sem variável extra como você pediu
$filtro_sql = "";
if (count($filtros) > 0) {
  $filtro_sql = "WHERE " . implode(" AND ", $filtros);
}

// Contagem com filtros
$sql_cont = "SELECT id FROM artes $sqlTagJoin $filtro_sql";
$query_cont = mysqli_query($conexao, $sql_cont);
$quantidade = mysqli_num_rows($query_cont);

// Paginação - sua lógica original
$paginaAtual = isset($_GET['pagina']) && !empty($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$paginaQtdd = 4;
$valorInicial = ($paginaAtual * $paginaQtdd) - $paginaQtdd;
$paginaFinal = ceil($quantidade / $paginaQtdd);
$paginaInicial = 1;
$paginaProxima = $paginaAtual + 1;
$paginaAnterior = $paginaAtual - 1;

// Consulta principal com filtros e limite
$sql = "SELECT artes.*, usuarios.nome AS nome_artista
        FROM artes
        LEFT JOIN usuarios ON artes.artista_id = usuarios.id
        $sqlTagJoin
        $filtro_sql
        ORDER BY artes.id DESC
        LIMIT $valorInicial, $paginaQtdd";
$res = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catálogo de Comissões</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../../css/catalogo.css" />
     <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<body>
  <?php include("../topo.php"); ?>

   <section class="catalogo container py-4">
    <h2>Catálogo de Comissões Abertas</h2>
 <button class="filtros-toggle" onclick="document.querySelector('.filtros-catalogo').classList.toggle('active')">
  Filtros
</button>




    <form method="GET" class="filtros-catalogo mb-4">
      <div class="row g-2">
        <div class="col-lg-3">
          <input type="search" name="pesquisa" id="pesquisa" class="form-control" placeholder="Pesquise por título..."
            value="<?= htmlspecialchars($pesquisa) ?>">
        </div>
        <div class="col-md-2">
          <input type="number" name="preco" id="preco" class="form-control" placeholder="Preço"
            value="<?= $preco !== null ? $preco : '' ?>">
        </div>
        <div class="col-md-3">
          <select name="filtro-promocao" id="filtro-promocao" class="form-control">
            <option value="">Promoções</option>
            <option value="sim" <?= $promocao === "sim" ? 'selected' : '' ?>>Em Promoção</option>
            <option value="nao" <?= $promocao === "nao" ? 'selected' : '' ?>>Sem Promoção</option>
          </select>
        </div>
        <div class="col-md-2">
          <input type="number" name="desconto" id="desconto" class="form-control" placeholder="Desconto (%)"
            value="<?= $desconto !== null ? $desconto : '' ?>">
        </div>
        <div class="col-md-2">
          <select name="tags" id="tags" class="form-control">
            <option value="">Tags</option>
            <?php
            $res_tag = mysqli_query($conexao, "SELECT id, nome FROM tags WHERE status = 1 ORDER BY nome ASC");
            while ($tag = mysqli_fetch_assoc($res_tag)) {
              $selected = ($tagId !== null && $tagId == $tag['id']) ? 'selected' : '';
              echo "<option value='{$tag['id']}' $selected>{$tag['nome']}</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="catalogo.php" class="btn btn-secondary">Limpar</a>
      </div>
    </form>

    <div class="row justify-content-center">
      <?php while ($linha = mysqli_fetch_assoc($res)) {
        $tags = [];
        $tag_res = mysqli_query($conexao, "SELECT t.nome FROM arte_tag at INNER JOIN tags t ON at.tag_id = t.id WHERE at.arte_id = {$linha['id']}");
        while ($t = mysqli_fetch_assoc($tag_res)) {
          $tags[] = "#" . $t['nome'];
        }

        $caminhoImagem = "../../images/produtos/" . $linha['imagem'];
        $imagem = (!empty($linha['imagem']) && file_exists($caminhoImagem)) ? $caminhoImagem : "../../images/assets/img/placeholder-produto.jpg";
        $preco = number_format($linha['preco'], 2, ',', '.');
        $temDesconto = $linha['desconto'] > 0;
        $precoFinal = $temDesconto ? $linha['preco'] * (1 - $linha['desconto'] / 100) : $linha['preco'];
        $precoFinalFormatado = number_format($precoFinal, 2, ',', '.');
        ?>

        <div class="catalogo-card m-2 position-relative"
          style="width: 250px; display: inline-block; vertical-align: top;">
          <?php if ($temDesconto) {
            echo "<div class='badge badge-pill badge-success position-absolute top-0 start-0 m-2' style='z-index: 1;'>Promoção</div>";
          } ?>
          <img src="<?= $imagem ?>" alt="Arte de <?= htmlspecialchars($linha['nome_artista']) ?>"
            style="width: 100%; height: 180px; object-fit: cover;">

          <div class="conteudo p-2">
            <h5 class="mb-1"><?= htmlspecialchars($linha['titulo']) ?></h5>
            <small class="text-muted">por <?= htmlspecialchars($linha['nome_artista']) ?></small><br>
            <p class="mb-1">
              <?php
              if ($temDesconto) {
                echo "<del style='font-size: 12px;'>R$ $preco</del> <strong class='text-success' style='font-size: 16px;'>R$ $precoFinalFormatado</strong>";
              } else {
                echo "R$ $preco";
              }
              ?>
            </p>
            <p class="mb-1"><?= implode(' ', $tags) ?></p>
            <a href="produto.php?id=<?= $linha['id'] ?>" class="btn btn-outline-primary btn-sm">Ver Produto</a>
          </div>
        </div>

      <?php } ?>
    </div>

    <div class="col-12 mt-5">
      <nav aria-label="paginacao">
        <ul class="pagination justify-content-center">
          <?php if ($paginaAtual != $paginaInicial) { ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaInicial ?>">Início</a></li>
          <?php } ?>

          <?php if ($paginaAtual >= 2) { ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaAnterior ?>" aria-label="Previous"><span
                  aria-hidden="true">&laquo;</span></a></li>
          <?php } ?>

          <?php if ($paginaAtual != $paginaFinal) { ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaProxima ?>" aria-label="Next"><span
                  aria-hidden="true">&raquo;</span></a></li>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $paginaFinal ?>">Final</a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>

  </section>

  <footer class="bg-rose text-white py-3 text-center rounded-top">
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>