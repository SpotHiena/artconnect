
  $(document).ready(function() {
    $('.select2').select2();

    $('#preco, #desconto').on('input', function () {
      let preco = parseFloat($('#preco').val().replace(',', '.')) || 0;
      let desconto = parseFloat($('#desconto').val()) || 0;
      let preco_final = preco - (preco * (desconto / 100));
      if (desconto > 100 || preco_final < 0) {
        $('#mensagem_erro').show();
        $('#preco_final').val('');
      } else {
        $('#mensagem_erro').hide();
        $('#preco_final').val(preco_final.toFixed(2).replace('.', ','));
      }
    });

    $('input[name="promocao"]').change(function () {
      if ($(this).val() == "1") {
        $('#desconto').prop('disabled', false);
      } else {
        $('#desconto').prop('disabled', true).val('');
        $('#preco_final').val('');
        $('#mensagem_erro').hide();
      }
    });
  });
