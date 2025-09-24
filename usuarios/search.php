<?php
session_start();
require_once '../conexao.php';

if (isset($_GET['busca']) && $_GET['busca'] != '') {
    $busca = $_GET['busca'];

    // PAGINAÇÃO
    $sql_cont = "SELECT id FROM artes WHERE titulo LIKE '%$busca%'";
    $query_cont = mysqli_query($conexao, $sql_cont);
    $quantidade = mysqli_num_rows($query_cont);

    $paginaAtual = isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1;
    $url = "?pagina=";
    $buscapag = "&busca=" . $busca;
    $paginaQtdd = 4;
    $valorInicial = ($paginaAtual * $paginaQtdd) - $paginaQtdd;
    $paginaFinal = ceil($quantidade / $paginaQtdd);
    $paginaInicial = 1;
    $paginaProxima = $paginaAtual + 1;
    $paginaAnterior = $paginaAtual - 1;

    // ARTES
    $sql = "SELECT artes.*, usuarios.nome AS nome_artista
        FROM artes 
        LEFT JOIN usuarios ON artes.artista_id = usuarios.id 
        WHERE titulo LIKE '%$busca%'
        ORDER BY artes.id DESC
        LIMIT $valorInicial, $paginaQtdd";

    $res = mysqli_query($conexao, $sql);
    if (!$res) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Busca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
   <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/busca.css">
    <style>
        .catalogo-card {
            width: 250px;
            display: inline-block;
            vertical-align: top;
            position: relative;
            margin: 10px;
        }

        .badge-success {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .catalogo .row {
            justify-content: center;
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<?php include("topo.php"); ?>

<body>
    <section class="catalogo">
        <h2>Buscas:</h2>
        <h2 class="titulo-main">Resultado para a <span>busca: <?php echo $busca ?> </span></h2>
        <div class="row mt-4">
            <?php while ($linha = mysqli_fetch_assoc($res)) {
                $tags = [];
                $tag_res = mysqli_query($conexao, "SELECT t.nome FROM arte_tag at INNER JOIN tags t ON at.tag_id = t.id WHERE at.arte_id = {$linha['id']}");
                while ($t = mysqli_fetch_assoc($tag_res)) {
                    $tags[] = "#" . $t['nome'];
                }

                $caminhoImagem = "../images/produtos/" . $linha['imagem'];
                $imagem = (!empty($linha['imagem']) && file_exists($caminhoImagem)) ? $caminhoImagem : "../images/assets/img/placeholder-produto.jpg";
                $preco = number_format($linha['preco'], 2, ',', '.');
                $temDesconto = $linha['desconto'] > 0;
                $precoFinal = $temDesconto ? $linha['preco'] * (1 - $linha['desconto'] / 100) : $linha['preco'];
                $precoFinalFormatado = number_format($precoFinal, 2, ',', '.');

                echo "
                <div class='catalogo-card'>
                    <img src='$imagem' alt='Arte de {$linha['nome_artista']}' style='width: 100%; height: 180px; object-fit: cover;'>";
                if ($temDesconto) {
                    echo "<div class='badge badge-pill badge-success'>Promoção</div>";
                }
                echo "
                    <div class='conteudo p-2'>
                        <h5 class='mb-1'>{$linha['titulo']}</h5>
                        <small class='text-muted'>por {$linha['nome_artista']}</small><br>
                        <p class='mb-1'>";
                if ($temDesconto) {
                    echo "<del style='font-size: 12px;'>R$ $preco</del> <strong class='text-success' style='font-size: 16px;'>R$ $precoFinalFormatado</strong>";
                } else {
                    echo "R$ $preco";
                }
                echo "</p>
                        <p class='mb-1'>" . implode(' ', $tags) . "</p>
                        <a href='catalogo/produto.php?id={$linha['id']}' class='btn-ver-perfil'>Ver Produto</a>
                    </div>
                </div>";
            } ?>
        </div>

        <div class="col-12 mt-5">
            <nav aria-label="paginacao">
                <ul class="pagination justify-content-center">
                    <?php if ($paginaAtual != $paginaInicial) { ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $paginaInicial . $buscapag; ?>">Início</a></li>
                    <?php } ?>
                    <?php if ($paginaAtual >= 2) { ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $paginaAnterior . $buscapag; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                    <?php } ?>
                    <?php if ($paginaAtual != $paginaFinal) { ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $paginaProxima . $buscapag; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo $paginaFinal . $buscapag; ?>">Final</a></li>
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