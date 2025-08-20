<?php
require_once '../conexao.php';
if (!isset($_SESSION))
  session_start();

// Pega 3 artes aleatórias
$sqlArtes = "
SELECT a.id, a.titulo, a.descricao, a.imagem, u.nome AS artista
FROM artes a
JOIN usuarios u ON a.artista_id = u.id
ORDER BY RAND() LIMIT 3
";
$resArtes = mysqli_query($conexao, $sqlArtes);

$artes = [];
while ($row = mysqli_fetch_assoc($resArtes)) {
  // Pega tags da arte
  $tagsSql = "SELECT t.nome FROM tags t 
              JOIN arte_tag at ON t.id = at.tag_id 
              WHERE at.arte_id = " . $row['id'];
  $tagsRes = mysqli_query($conexao, $tagsSql);
  $tags = [];
  while ($tagRow = mysqli_fetch_assoc($tagsRes)) {
    $tags[] = $tagRow['nome'];
  }
  $row['tags'] = $tags;
  $artes[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Art Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<?php include("topo.php"); ?>

<body>

  <!-- HERO -->
  <section class="hero">
    <div class="container text-center">
      <h2 class="mb-4">Encontre Artistas para suas Comissões</h2>
      <form class="d-flex justify-content-center" role="search" action="<?= $url ?>search.php" method="get">
        <div class="input-group w-50">
          <input type="search" name="busca" class="form-control rounded-start"
            placeholder="Pesquise por estilo, nome..." aria-label="Search">
          <button class="btn btn-light rounded-end fw-bold" type="submit">🔍 Buscar</button>
        </div>
      </form>
    </div>
  </section>

  <!-- CARROSSEL COM MODAL -->
  <section class="artistas-destaque py-5">
    <div class="container">
      <h2 class="text-center mb-4">✨ Destaques Personalizados</h2>
      <div class="carousel">
        <?php foreach ($artes as $index => $arte): ?>
          <div class="artista px-2">
            <button type="button" class="artista-destaque-btn btn p-0 border-0 shadow-sm rounded" data-bs-toggle="modal"
              data-bs-target="#modalArte" data-index="<?= $index ?>" style="width: 100%;">
              <div class="box-image overflow-hidden rounded">
                <img src="<?= htmlspecialchars('../images/produtos/' . trim($arte['imagem'])) ?>"
                  alt="<?= htmlspecialchars($arte['titulo']) ?>" class="img-fluid rounded"
                  style="height: 25rem; width: 100%; object-fit: cover;">
              </div>
              <div class="detalhes text-center mt-2">
                <h4 class="mb-0"><?= htmlspecialchars($arte['titulo']) ?></h4>
              </div>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Modal único -->
  <div class="modal fade" id="modalArte" tabindex="-1" aria-labelledby="modalArteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content modal-artista rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold" id="modalArteLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body modal-body-artista d-flex flex-wrap gap-3">
          <img id="modalArteFoto" src="" alt="Arte" class="modal-img-artista rounded-3 shadow-sm" style="width: 250px;">
          <div class="modal-info-artista flex-grow-1">
            <p id="modalArteDescricao" class="modal-descricao fs-5"></p>
            <p id="modalArteArtista" class="fs-6 fw-bold"></p>
            <div id="modalArteTags"></div>
            <div class="mt-3">
              <!-- Botão para ver o produto -->
              <a id="modalArteVerProduto" href="#" class="btn btn-primary">Ver Produto</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="jumbotron-bobross">
    <div class="container" style="max-width: 800px;">
      <blockquote class="fs-4 fst-italic mb-4">
        "Você não está falhando contanto que esteja aprendendo"
      </blockquote>
      <div class="d-flex flex-column align-items-center">
        <img src="../images/assets/img/bob.png" alt="Bob Ross" class="rounded-circle mb-2"
          style="width: 100px; height: 100px;">
        <span class="fs-5">-Bob Ross</span>
      </div>
    </div>
  </section>

  <hr class="separador">

  <section class="exemplo py-5">
    <div class="container d-flex flex-wrap align-items-center gap-4">
      <img src="../images/assets/img/arte.png" alt="exemplo" class="imagem-sobre rounded-4 shadow-sm"
        style="max-width: 400px;">
      <div>
        <h3 class="text-primary mb-3">Sobre Nós</h3>
        <p>
          Nosso site foi criado com a ideia de ajudar artistas grandes ou pequenos que têm dificuldades tanto na parte
          de
          venda quanto na de comunicação. Nosso objetivo é incluir essas pessoas, ajudá-las a expandir seus negócios e
          divulgar seus trabalhos! Também oferecemos ferramentas de portfólio, avaliações, filtros personalizados,
          formas de
          pagamento diversas e muito mais para conectar artistas e clientes de forma prática. Alavanque suas vendas de
          arte
          e cresça no ramo!
        </p>
      </div>
    </div>
  </section>

  <hr class="separador">

  <section class="secao-duvidas py-5 bg-white">
    <div class="container text-center">
      <h3 class="mb-4">Dúvidas?</h3>
      <div class="duvidas d-flex justify-content-center">
        <form id="form-duvidas" class="w-100 w-md-50 p-4 border rounded shadow-sm">
          <input type="text" name="nome" placeholder="Nome" required class="form-control mb-3 rounded" />
          <input type="email" name="email" placeholder="Email" required class="form-control mb-3 rounded" />
          <textarea name="mensagem" placeholder="Enviar dúvida" required class="form-control mb-3 rounded"
            rows="4"></textarea>
          <button type="submit" class="btn btn-primary w-100 rounded">Enviar via WhatsApp</button>
        </form>
      </div>
    </div>
  </section>

  <footer class="bg-rose text-white py-3 text-center rounded-top">
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
  </footer>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      // Inicializa slick carousel
      $('.carousel').slick({
        infinite: true,
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        autoplaySpeed: 2000,
        responsive: [
          { breakpoint: 768, settings: { slidesToShow: 1 } }
        ]
      });

      const artes = <?= json_encode($artes); ?>;

      // Atualiza modal quando abrir
      $('#modalArte').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const index = button.data('index');
        const arte = artes[index];

        $('#modalArteLabel').text(arte.titulo);
        $('#modalArteFoto').attr('src', '../images/produtos/' + arte.imagem);
        $('#modalArteFoto').attr('alt', arte.titulo);
        $('#modalArteDescricao').text(arte.descricao);
        $('#modalArteArtista').text('Artista: ' + arte.artista);

        // Tags
        $('#modalArteTags').html('');
        arte.tags.forEach(tag => {
          $('#modalArteTags').append('<span class="badge bg-secondary me-1">' + tag + '</span>');
        });

        // Botão Ver Produto
        $('#modalArteVerProduto').attr('href', 'catalogo/produto.php?id=' + arte.id);
      });
    });

    document.getElementById('form-duvidas').addEventListener('submit', function (e) {
      e.preventDefault();

      const nome = this.nome.value.trim();
      const email = this.email.value.trim();
      const mensagem = this.mensagem.value.trim();

      const numero = '5519998189591';

      const texto = `Olá, meu nome é ${nome}.\nEmail: ${email}\nMensagem: ${mensagem}`;

      const link = `https://wa.me/${numero}?text=${encodeURIComponent(texto)}`;

      window.open(link, '_blank');
  </script>

</body>

</html>