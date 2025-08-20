<?php
require_once '../conexao.php';
if (!isset($_SESSION)) session_start();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guia de Compras</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
<link rel="stylesheet" href="../css/guia.css">
   <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>
<?php include("topo.php"); ?>

<body>
  <section class="guia">
    <div class="guia-container">
      <h2>🧭 Guia de Compras</h2>
      <p>Um passo a passo simples e um glossário com termos importantes do mundo da arte digital.</p>

      <div class="guia-passoapasso">
        <h3>📌 Passo a Passo para Contratar</h3>
        <ol>
          <li><strong>Escolha um artista:</strong> Use os filtros na aba “Artistas” para encontrar um que combine com você.</li>
          <li><strong>Veja o perfil:</strong> Verifique a galeria, o estilo e a tabela de preços do artista.</li>
          <li><strong>Envie sua ideia:</strong> Use o botão de contato e explique o que você deseja.</li>
          <li><strong>Combine os detalhes:</strong> Prazo, preço, forma de pagamento e estilo.</li>
          <li><strong>Acompanhe o progresso:</strong> Alguns artistas atualizam o andamento por etapas.</li>
          <li><strong>Receba sua arte!</strong> Aprecie sua obra exclusiva! 🖼️</li>
        </ol>
      </div>

      <div class="guia-glossario">
        <h3>📖 Glossário de Termos</h3>
        <ul>
          <li><strong>Lineart:</strong> Contorno ou traçado da arte antes da coloração.</li>
          <li><strong>Sketch:</strong> Rascunho inicial, muitas vezes usado para aprovação.</li>
          <li><strong>Render:</strong> Parte da pintura com detalhes, luz e sombra.</li>
          <li><strong>Flat Colors:</strong> Cores chapadas, sem sombra ou textura.</li>
          <li><strong>Commission:</strong> Uma arte feita sob encomenda.</li>
          <li><strong>OC (Original Character):</strong> Personagem criado por você.</li>
          <li><strong>Slot:</strong> Vaga disponível para encomendas.</li>
        </ul>
      </div>
    </div>
  </section>
    <footer class="bg-rose text-white py-3 text-center rounded-top">
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
  </footer>
</body>
</html>
