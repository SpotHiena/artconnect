function getIdFromUrl() {
  const p = new URLSearchParams(window.location.search);
  const id = parseInt(p.get('id') || '0', 10);
  return isNaN(id) ? 0 : id;
}
const ID_PAGINA = getIdFromUrl();

function carregarGaleria(q = '') {
  $.ajax({
    url: 'acoes.php',
    method: 'GET',
    data: { busca: q, id: ID_PAGINA },
    success: function (res) {
      $('#galeria-cards').html(res);
    },
    error: function () {
      $('#galeria-cards').html('<div class="text-center text-muted py-4">Erro ao carregar galerias. Tente recarregar a página.</div>');
    }
  });
}

function abrirDetalhes(obj) {
  $('#modalImagem').attr('src', obj.imagem);
  $('#modalTitulo').text(obj.titulo);
  $('#modalDescricao').text(obj.descricao || '—');
  $('#modalTags').text(obj.tags || '');
  $('#modalPreco').text(obj.preco || '0,00');
  $('#btnEditar').attr('href', 'editar-arte.php?id=' + obj.id);

  // Mostra ou esconde botões se o usuário for dono
  if (obj.dono === true || obj.dono === 'true') {
    $('#btnEditar').show();
    $('#btnExcluir').show();
    $('#btnExcluir').data('id', obj.id);
  } else {
    $('#btnEditar').hide();
    $('#btnExcluir').hide();
    $('#btnExcluir').removeData('id');
  }

  const modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
  modal.show();
}

$(document).ready(function () {
  // Carrega a galeria ao abrir a página
  carregarGaleria();

  // Abrir modal ao clicar em uma arte
  $(document).on('click', '.card-arte', function (e) {
    e.preventDefault();
    const $t = $(this);

    const dados = {
      id: $t.data('id'),
      imagem: $t.data('imagem'),
      titulo: $t.data('titulo'),
      descricao: $t.data('descricao'),
      tags: $t.data('tags'),
      preco: $t.data('preco'),
      dono: $t.data('dono') // ⚡ só true se for dono
    };
    abrirDetalhes(dados);
  });

  // Excluir arte
  $('#btnExcluir').on('click', function () {
    const id = $(this).data('id');
    if (!id) return;
    if (!confirm('Excluir esta arte?')) return;

    $.post('acoes.php', { deletar: id }, function () {
      carregarGaleria();
      const modalEl = document.getElementById('modalDetalhes');
      const modalObj = bootstrap.Modal.getInstance(modalEl);
      if (modalObj) modalObj.hide();
      $('#msg-area').html('<div class="alert alert-success mt-3">Arte excluída com sucesso.</div>');
      setTimeout(() => $('#msg-area').fadeOut(600), 2500);
    }).fail(function () {
      $('#msg-area').html('<div class="alert alert-danger mt-3">Erro ao excluir. Tente novamente.</div>');
    });
  });

  // Filtrar galeria
  $('#btnFiltrar').on('click', function () {
    const q = $('#filtroBusca').val().trim();
    carregarGaleria(q);
  });

  // Filtrar com Enter
  $('#filtroBusca').on('keypress', function (e) {
    if (e.which === 13) { 
      $('#btnFiltrar').click(); 
    }
  });
});
