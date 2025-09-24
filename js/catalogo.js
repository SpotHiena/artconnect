
    document.querySelectorAll('select').forEach(select => {
      select.addEventListener('change', () => {
        const estilo = document.getElementById("filtro-estilo").value;
        const promocao = document.getElementById("filtro-promocao").value;
        const cards = document.querySelectorAll('.catalogo-card');
        let visiveis = 0;

        cards.forEach(card => {
          const estiloCard = card.dataset.estilo;
          const promoCard = card.dataset.promocao;
          const matchEstilo = !estilo || estiloCard === estilo;
          const matchPromo = !promocao || promoCard === promocao;

          const mostrar = matchEstilo && matchPromo;
          card.style.display = mostrar ? "block" : "none";

          if (mostrar) visiveis++;
        });

        document.getElementById("semArtistas").style.display = visiveis === 0 ? "block" : "none";
      });
    });
