<?php
session_start();
require_once '../../conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produto não encontrado.";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT artes.*, usuarios.nome AS nome_artista 
        FROM artes
        LEFT JOIN usuarios ON artes.artista_id = usuarios.id
        WHERE artes.id = $id
        LIMIT 1";
$res = mysqli_query($conexao, $sql);

if (mysqli_num_rows($res) === 0) {
    echo "Produto não encontrado.";
    exit;
}

$produto = mysqli_fetch_assoc($res);

// Buscar tags do produto
$tags = [];
$tag_ids = [];
$tag_res = mysqli_query($conexao, "SELECT t.id, t.nome 
                                   FROM arte_tag at 
                                   INNER JOIN tags t ON at.tag_id = t.id 
                                   WHERE at.arte_id = {$produto['id']}");
while ($t = mysqli_fetch_assoc($tag_res)) {
    $tags[] = "#" . $t['nome'];
    $tag_ids[] = $t['id'];
}

// Imagem principal
$caminhoImagem = "../../images/produtos/" . $produto['imagem'];
$imagem = (!empty($produto['imagem']) && file_exists($caminhoImagem))
    ? $caminhoImagem
    : "../../images/assets/img/placeholder-produto.jpg";

// Preço principal
$preco = number_format($produto['preco'], 2, ',', '.');
$temDesconto = $produto['desconto'] > 0;
$precoFinal = $temDesconto
    ? $produto['preco'] * (1 - $produto['desconto'] / 100)
    : $produto['preco'];
$precoFinalFormatado = number_format($precoFinal, 2, ',', '.');

// PAGINAÇÃO dos produtos relacionados
$itens_por_pagina = 3;
$pagina_atual = isset($_GET['pagina_rel']) && is_numeric($_GET['pagina_rel']) ? intval($_GET['pagina_rel']) : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// Contar total produtos relacionados por tags
$total_relacionados = 0;
if (!empty($tag_ids)) {
    $tag_ids_str = implode(',', $tag_ids);
    $sql_count = "SELECT COUNT(DISTINCT a.id) as total 
                  FROM artes a
                  INNER JOIN arte_tag at ON a.id = at.arte_id
                  WHERE at.tag_id IN ($tag_ids_str)
                  AND a.id != {$produto['id']}";
    $res_count = mysqli_query($conexao, $sql_count);
    if ($res_count) {
        $row = mysqli_fetch_assoc($res_count);
        $total_relacionados = intval($row['total']);
    }
}

// Se não achar por tags, contar por artista
if ($total_relacionados === 0) {
    $sql_count = "SELECT COUNT(*) as total 
                  FROM artes 
                  WHERE artista_id = {$produto['artista_id']} 
                  AND id != {$produto['id']}";
    $res_count = mysqli_query($conexao, $sql_count);
    if ($res_count) {
        $row = mysqli_fetch_assoc($res_count);
        $total_relacionados = intval($row['total']);
    }
}

// Calcular total de páginas
$total_paginas = ceil($total_relacionados / $itens_por_pagina);

// Buscar os produtos relacionados da página atual
$relacionados = [];
if ($total_relacionados > 0) {
    if ($total_relacionados > 0 && !empty($tag_ids)) {
        $sql_rel = "SELECT DISTINCT a.* 
                    FROM artes a
                    INNER JOIN arte_tag at ON a.id = at.arte_id
                    WHERE at.tag_id IN ($tag_ids_str)
                    AND a.id != {$produto['id']}
                    LIMIT $offset, $itens_por_pagina";
    } else {
        $sql_rel = "SELECT * FROM artes 
                    WHERE artista_id = {$produto['artista_id']} 
                    AND id != {$produto['id']} 
                    LIMIT $offset, $itens_por_pagina";
    }
    $res_rel = mysqli_query($conexao, $sql_rel);
    while ($rel = mysqli_fetch_assoc($res_rel)) {
        $relacionados[] = $rel;
    }
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $produto['titulo']; ?> - Detalhes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/produto.css" />
       <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
    <style>

    </style>
</head>

<?php include("../topo.php"); ?>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $imagem; ?>" alt="Imagem do produto" class="img-fluid rounded img-produto" />
            </div>

            <div class="col-md-6">
                <h2><?php echo $produto['titulo']; ?></h2>
                <p class="text-muted">por <?php echo $produto['nome_artista']; ?></p>

                <p>
                    <?php if ($temDesconto) { ?>
                        <del style="font-size: 14px;">R$ <?php echo $preco; ?></del>
                        <strong class="text-success" style="font-size: 20px;">R$
                            <?php echo $precoFinalFormatado; ?></strong>
                    <?php } else { ?>
                        <strong style="font-size: 20px;">R$ <?php echo $preco; ?></strong>
                    <?php } ?>
                </p>

                <p><?php echo !empty($produto['descricao']) ? nl2br($produto['descricao']) : "Sem descrição disponível."; ?>
                </p>
                <p class="text-primary"><?php echo implode(' ', $tags); ?></p>

                <a href="catalogo.php" class="btn btn-secondary">Voltar ao Catálogo</a>
            </div>
        </div>

        <hr class="my-5" />

        <h4>Produtos Relacionados</h4>
        <div class="row">
            <?php
            if (!empty($relacionados)) {
                foreach ($relacionados as $rel) {
                    $caminhoImagemRel = "../../images/produtos/" . $rel['imagem'];
                    $imgRel = (!empty($rel['imagem']) && file_exists($caminhoImagemRel))
                        ? $caminhoImagemRel
                        : "../../images/assets/img/placeholder-produto.jpg";

                    $pre_sem = number_format($rel['preco'], 2, ',', '.');
                    $temDes = $rel['desconto'] > 0;
                    if ($temDes) {
                        $preSemFinal = $rel['preco'] * (1 - $rel['desconto'] / 100);
                        $preSemFinalFmt = number_format($preSemFinal, 2, ',', '.');
                    }
                    ?>
                    <div class="col-md-3 col-6 mb-4 text-center">
                        <div class="card card-relacionado p-2">
                            <a href="produto.php?id=<?php echo $rel['id']; ?>">
                                <img src="<?php echo $imgRel; ?>" alt="<?php echo $rel['titulo']; ?>" />
                                <h6 class="mt-2"><?php echo $rel['titulo']; ?></h6>
                            </a>
                            <?php
                            if ($temDes) {
                                echo "<small><del style='font-size:12px;'>R$ {$pre_sem}</del> <strong style='color:green;'>R$ {$preSemFinalFmt}</strong></small>";
                            } else {
                                echo "<small>R$ {$pre_sem}</small>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='ml-3'>Nenhum produto relacionado encontrado.</p>";
            }
            ?>
        </div>

        <!-- PAGINAÇÃO -->
        <?php if ($total_paginas > 1): ?>
            <nav aria-label="Paginação produtos relacionados">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?php echo ($i == $pagina_atual) ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?id=<?php echo $produto['id']; ?>&pagina_rel=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <footer class="bg-rose text-white py-3 text-center rounded-top">
        <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
    </footer>
</body>

</html>