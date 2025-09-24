<?php
session_start();
require_once '../../../conexao.php';

// Pega o ID da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id_usuario = intval($_GET['id']);
} else {
  echo "ID do usuário não informado.";
  exit;
}

// Busca informações do usuário
$sql = "SELECT apelido, foto, nome, descricao 
        FROM usuarios 
        WHERE id = $id_usuario 
        LIMIT 1";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
  echo "Usuário não encontrado.";
  exit;
}

$usuario = mysqli_fetch_assoc($resultado);
$apelido = htmlspecialchars($usuario['apelido']);
$foto = (!empty($usuario['foto']) && file_exists("../../../images/perfil/{$usuario['foto']}"))
  ? "../../../images/perfil/{$usuario['foto']}"
  : "../../../images/assets/img/placeholder-funcionario.png";
$nome_completo = htmlspecialchars($usuario['nome']);
$descricao = htmlspecialchars($usuario['descricao']);

// Verifica se o visitante é o dono do perfil
$isDonoPerfil = isset($_SESSION['ID']) && $_SESSION['ID'] === $id_usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Galeria do Usuário - ArtConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../../../css/galeria.css">
  <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<?php include("../../topo.php"); ?>

<body>
  <main class="container-usuario">
    <?php include("../navegacao.php"); ?>

    <section class="perfil-top mb-4">
      <div class="avatar">
        <img src="<?= $foto ?>" alt="Foto de perfil" class="profile-pic" />
      </div>

      <div class="info">
        <h3><?= $apelido ?>
          <?php if ($nome_completo): ?>
            <small style='font-weight:600; font-size:0.85rem; color:#9b627a'>&nbsp;&middot;&nbsp;<?= $nome_completo ?></small>
          <?php endif; ?>
        </h3>
        <p><?= $descricao ?></p>
      </div>

      <!-- Botão de adicionar arte só aparece para o dono do perfil -->
      <?php if ($isDonoPerfil): ?>
        <div class="perfil-actions">
          <a href="inserir.php" class="btn btn-pastel">+ Nova Arte</a>
        </div>
      <?php endif; ?>
    </section>

    <?php include '../../mensagem.php'; ?>

    <section class="galeria">
      <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <h2 class="titulo-aba">Minhas Artes</h2>
      </div>
      <div class="linha-separadora"></div>

      <div id="galeria-cards" class="mt-3">
        <?php
        // Busca artes apenas do usuário da URL
        $sqlArtes = "SELECT * FROM artes WHERE artista_id = $id_usuario ORDER BY id DESC";
        $resArtes = mysqli_query($conexao, $sqlArtes);

        if ($resArtes && mysqli_num_rows($resArtes) > 0) {
          while ($arte = mysqli_fetch_assoc($resArtes)):
            $imagemArte = !empty($arte['imagem']) && file_exists("../../../images/artes/{$arte['imagem']}")
              ? "../../../images/artes/{$arte['imagem']}"
              : "../../../images/assets/img/placeholder-funcionario.png";
        ?>
          <div class="card-art" data-id="<?= $arte['id'] ?>">
            <img src="<?= $imagemArte ?>" alt="<?= htmlspecialchars($arte['titulo']) ?>">
            <h4><?= htmlspecialchars($arte['titulo']) ?></h4>

            <?php if ($isDonoPerfil): ?>
              <div class="acoes-card">
                <a href="editar.php?id=<?= $arte['id'] ?>" class="btn btn-sm btn-pastel">Editar</a>
                <form method="POST" action="deletar.php" style="display:inline">
                  <input type="hidden" name="id" value="<?= $arte['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php
          endwhile;
        } else {
          echo "<p>Este usuário ainda não publicou artes.</p>";
        }
        ?>
      </div>

      <div id="msg-area" class="mt-4"></div>
    </section>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../js/galeria.js"></script>
</body>

<footer class="bg-rose text-white py-3 text-center rounded-top">
  <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>
</html>
