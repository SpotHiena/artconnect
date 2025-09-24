<?php
require_once '../../../conexao.php';
if (!isset($_SESSION))
    session_start();

// Pega ID via GET, se não existe, mostra erro
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Usuário não especificado.";
    exit;
}

$id_usuario = intval($_GET['id']);

// Busca dados do usuário/artista
$sql = "SELECT id, nome, apelido, foto, descricao, email, data_nascimento, sexo FROM usuarios WHERE id = $id_usuario LIMIT 1";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    echo "Usuário não encontrado.";
    exit;
}

$usuario = mysqli_fetch_assoc($resultado);

// Formata data de nascimento
$data_nascimento_formatada = !empty($usuario['data_nascimento']) ? date('d/m/Y', strtotime($usuario['data_nascimento'])) : '';

// Caminho da foto (com placeholder se não existir)
$caminho_perfil = '../../../images/perfil/';
$placeholder = '../../../images/assets/img/placeholder-funcionario.png';
$foto_perfil = (!empty($usuario['foto']) && file_exists($caminho_perfil . $usuario['foto']))
               ? $caminho_perfil . $usuario['foto']
               : $placeholder;

// Verifica se é o próprio usuário logado
$proprio_usuario = isset($_SESSION['ID']) && $_SESSION['ID'] == $id_usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Perfil do Artista</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../css/perfil.css" />
</head>

<body>
  <?php include("../../topo.php"); ?>

  <div class="usuario container-usuario" style="padding-left: 16px;">
    <div class="painel-container">
      <?php include("../navegacao.php"); ?>

      <main class="container">
        <div class="perfil-wrapper">
          <?php include '../../../mensagem.php'; ?>

          <div class="cover">
            <img src="<?= $foto_perfil ?>" alt="Foto de perfil" class="profile-pic" />
          </div>

          <div class="profile-body">
            <h2><?= htmlspecialchars($usuario['nome']) ?></h2>
            <p>@<?= htmlspecialchars($usuario['apelido']) ?></p>

            <?php if (!empty($usuario['descricao'])): ?>
              <p>"<?= htmlspecialchars($usuario['descricao']) ?>"</p>
            <?php endif; ?>

            <div class="badges">
              <span class="badge-custom"><?= htmlspecialchars($usuario['sexo']) ?></span>
              <?php if (!empty($usuario['data_nascimento'])): ?>
                <span class="badge-custom">Nascimento: <?= $data_nascimento_formatada ?></span>
              <?php endif; ?>
            </div>

            <div class="info-grid">
              <?php if ($proprio_usuario): ?>
                <div class="info-item">
                  <label>Nome completo</label>
                  <span><?= htmlspecialchars($usuario['nome']) ?></span>
                </div>
                <div class="info-item">
                  <label>Email</label>
                  <span><?= htmlspecialchars($usuario['email']) ?></span>
                </div>
              <?php endif; ?>

              <div class="info-item">
                <label>Apelido</label>
                <span><?= htmlspecialchars($usuario['apelido']) ?></span>
              </div>
              <div class="info-item">
                <label>Sexo</label>
                <span><?= htmlspecialchars($usuario['sexo']) ?></span>
              </div>
              <?php if (!empty($usuario['descricao'])): ?>
                <div class="info-item" style="grid-column: span 2;">
                  <label>Descrição</label>
                  <span><?= htmlspecialchars($usuario['descricao']) ?></span>
                </div>
              <?php endif; ?>
            </div>

            <?php if ($proprio_usuario): ?>
              <div class="edit-button">
                <a href="editar-perfil.php"><button>Editar Perfil</button></a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>

</html>
