

<?php
require_once '../../conexao.php';

// rotina de paginação
$sql_cont = "SELECT id FROM artes"; //contar quantos produtos tem no banco

$query_cont = mysqli_query($conexao, $sql_cont);
$quantidade = mysqli_num_rows($query_cont);

if(isset($_GET['pagina']) && !empty($_GET['pagina'])) //se tiver um numero e/ou for diverente de vazio vai pegar o numero da pagina
{
    $paginaAtual = $_GET['pagina']; //se nao tiver no link o numero da pagina a pagina é 1
}else{
    $paginaAtual= 1;
}

$url = "?pagina="; //tem que ser igual ao do get, vai mostrar no url o numero da pagina

$paginaQtdd= 4; //controla a quantidade de produtos que vai aparecer por pagina

//VALOR INICIAL PARA CLAUSULA LIMIT
$valorInicial = ($paginaAtual * $paginaQtdd) - $paginaQtdd; //FAZ UM CALCULO QUE VE QUAL PAGINA ESTA, A QUANTIDADE DE PRODUTO QUE APARECE POR PAGINA, E EM SEGUINTE VAI MOSTRAR A PARTIR DO ULTIMO NUMERO MOSTRADO


$paginaFinal= ceil($quantidade / $paginaQtdd); //a função CEIL arredonda o valor de paginas, pra nunca dar um valor pela metade. 

$paginaInicial =1;

$paginaProxima = $paginaAtual + 1;

$paginaAnterior = $paginaAtual - 1;


// FILTROS
$titulo = mysqli_real_escape_string($conexao, $_POST['titulo'] ?? '');
$preco = $_POST['preco'] ?? '';
$desconto = $_POST['desconto'] ?? '';
$tags = $_POST['tags'] ?? '';

$sql = "SELECT artes.*, usuarios.nome AS nome_artista, tags.nome AS lista_tags
        FROM artes
        LEFT JOIN usuarios ON artes.artista_id = usuarios.id
        LEFT JOIN arte_tag ON artes.id = arte_tag.arte_id
        LEFT JOIN tags ON tags.id = arte_tag.tag_id
        WHERE 1=1";

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

$sql .= " GROUP BY artes.id ORDER BY artes.id DESC LIMIT $valorInicial, $paginaQtdd";

$res = mysqli_query($conexao, $sql);

if (mysqli_num_rows($res) == 0) {
    echo "<div>Nenhuma arte encontrada.</div>";
    exit;
}

while ($linha = mysqli_fetch_assoc($res)) {
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

    echo "
    <div class='catalogo-card m-2' style='width: 250px; display: inline-block; vertical-align: top; position: relative;'>
        <img src='$imagem' alt='Arte de {$linha['nome_artista']}'  style='width: 100%; height: 180px; object-fit: cover;' >";

    if ($temDesconto) {
        echo "<div class='badge badge-pill badge-success'>Promoção</div>";
    }

    echo "
        <div class='conteudo p-2'>
            <h5 class='mb-1'>{$linha['titulo']}</h5>
            <small class='text-muted'>por {$linha['nome_artista']}</small><br>
            <p class='mb-1'>
                " . ($temDesconto ? "<del style='font-size: 12px;'>R$ $preco</del> <strong class='text-success' style='font-size: 16px;' >R$ $precoFinalFormatado</strong>" : "R$ $preco") . "
            </p>
            <p class='mb-1'>" . implode(' ', $tags) . "</p>
            <a href='../perfil.php?id={$linha['artista_id']}' style='margin-top: 12px; display: inline-block; padding: 8px 12px; background: #ff9800; color: white; font-weight: bold; border-radius: 6px; text-decoration: none; transition: background 0.3s;'>Ver Perfil</a>
        </div>
    </div>
    ";
}
?>

<div class="col-12 mt-5">
    <nav aria-label="paginacao">
        <ul class="pagination justify-content-center">

            <?php if ($paginaAtual != $paginaInicial) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url . $paginaInicial ?>">Início</a>
                </li>
            <?php } ?>

            <?php if ($paginaAtual >= 2) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url . $paginaAnterior ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($paginaAtual != $paginaFinal) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url . $paginaProxima ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $url . $paginaFinal ?>">Final</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
