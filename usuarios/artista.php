<?php
session_start();
require_once '../conexao.php';

$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$preco_min = isset($_GET['preco_min']) ? floatval($_GET['preco_min']) : 0;
$preco_max = isset($_GET['preco_max']) ? floatval($_GET['preco_max']) : 0;


$sql = "SELECT u.id, u.nome, u.apelido, u.foto, MIN(a.preco) AS preco_min, MAX(a.preco) AS preco_max FROM usuarios u LEFT JOIN artes a ON a.artista_id = u.id AND a.status = 1 WHERE u.status = 1
";

// Filtro nome
if ($nome !== '') {
  $nome_esc = mysqli_real_escape_string($conexao, $nome);
  $sql .= " AND (u.nome LIKE '%$nome_esc%' OR u.apelido LIKE '%$nome_esc%') ";
}

// Filtra por artes dentro do intervalo de preço
if ($preco_min > 0) {
  $sql .= " AND EXISTS (
        SELECT 1 FROM artes a2
        WHERE a2.artista_id = u.id
          AND a2.status = 1
          AND a2.preco >= $preco_min
    ) ";
}
if ($preco_max > 0) {
  $sql .= " AND EXISTS (
        SELECT 1 FROM artes a3
        WHERE a3.artista_id = u.id
          AND a3.status = 1
          AND a3.preco <= $preco_max
    ) ";
}

$sql .= " GROUP BY u.id ORDER BY u.nome ASC";

$res = mysqli_query($conexao, $sql);
if (!$res) {
  die("Erro na consulta: " . mysqli_error($conexao));
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Filtro de Artistas</title>
     <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../css/artistas.css" />
     <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
  
</head>

<body>
  <?php include("topo.php"); ?>

  <div class="artistas-page">
    <div class="container">
      <button class="filtros-toggle" onclick="document.querySelector('.filtros').classList.toggle('active')"> Filtros
      </button>

      <aside class="filtros">
        <h2>Filtros</h2>
        <form method="GET">
          <label for="nome">Nome ou Apelido:</label>
          <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>"
            placeholder="Buscar artista" />

          <label for="preco_min">Preço Mínimo (R$):</label>
          <input type="number" id="preco_min" name="preco_min" step="0.01" min="0"
            value="<?php echo $preco_min > 0 ? $preco_min : ''; ?>" />

          <label for="preco_max">Preço Máximo (R$):</label>
          <input type="number" id="preco_max" name="preco_max" step="0.01" min="0"
            value="<?php echo $preco_max > 0 ? $preco_max : ''; ?>" />

          <input type="submit" value="Filtrar" />
        </form>
      </aside>

      <section class="lista-artistas">
        <?php if (mysqli_num_rows($res) === 0): ?>
          <p class="sem-resultados">Nenhum artista encontrado.</p>
        <?php else: ?>
          <?php while ($usuario = mysqli_fetch_assoc($res)): ?>
            <div class="artista-card">
              <img
                src="<?php echo !empty($usuario['foto']) ? '../images/perfil/' . htmlspecialchars($usuario['foto']) : '../images/assets/img/placeholder-funcionario.png'; ?>"
                alt="Foto de <?php echo htmlspecialchars($usuario['nome']); ?>" class="foto-artista" />
              <p class="apelido">@<?php echo htmlspecialchars($usuario['apelido'] ?: 'sem-apelido'); ?></p>
              <p class="preco">
                Faixa de preço:<br>
                <?php
                if ($usuario['preco_min'] !== null) {
                  echo "R$ " . number_format($usuario['preco_min'], 2, ',', '.') . " - R$ " . number_format($usuario['preco_max'], 2, ',', '.');
                } else {
                  echo "Sem artes cadastradas";
                }
                ?>
              </p>
              <button onclick="window.location.href='perfil/perfil/usuario.php?id=<?php echo $usuario['id']; ?>'">Ver
                Perfil</button>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </section>

    </div>
  </div>

  <footer class="bg-rose text-white py-3 text-center rounded-top">
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
  </footer>

</body>

</html>