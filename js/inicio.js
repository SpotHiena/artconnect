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
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1
            }
          }
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
      });
    });

