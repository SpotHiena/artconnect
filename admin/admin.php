<?php 
require_once '../conexao.php';

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['USER'])) {
  $_SESSION['naoAutorizado'] = "Apenas usuários cadastrados podem acessar esta área!";
  header('Location: index.php');
  exit;
}

if ($_SESSION['TYPE'] != 1) {
  $_SESSION['naoAutorizado'] = "Apenas administradores podem acessar esta área!";
  header('Location: index.php');
  exit;
}

// Função para contar registros
function contarRegistros($conexao, $tabela) {
    $sql = "SELECT COUNT(*) AS total FROM $tabela";
    $resultado = $conexao->query($sql);
    if ($resultado) {
        $linha = $resultado->fetch_assoc();
        return $linha['total'];
    }
    return 0;
}

// Métricas rápidas
$totalUsuarios = contarRegistros($conexao, "usuarios");
$totalArtes = contarRegistros($conexao, "artes");
$totalTags = contarRegistros($conexao, "tags");
$totalFuncionarios = contarRegistros($conexao, "funcionario");

// Aniversariantes do mês - Usuários
$aniversariantesUsuarios = [];
$sql = "SELECT nome, apelido, data_nascimento 
        FROM usuarios 
        WHERE MONTH(data_nascimento) = MONTH(CURDATE()) 
        ORDER BY DAY(data_nascimento)";
$res = $conexao->query($sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $aniversariantesUsuarios[] = $row;
    }
}

// Aniversariantes do mês - Funcionários
$aniversariantesFuncionarios = [];
$sql = "SELECT f.nome, c.nome AS cargo, f.data_nascimento 
        FROM funcionario f
        LEFT JOIN cargo c ON c.codigo_cargo = f.codigo_cargo
        WHERE MONTH(f.data_nascimento) = MONTH(CURDATE()) 
        ORDER BY DAY(f.data_nascimento)";
$res = $conexao->query($sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $aniversariantesFuncionarios[] = $row;
    }
}


// Top usuários com mais publicações de artes
$topPublicadores = [];
$sql = "SELECT u.nome, u.apelido, COUNT(a.id) AS total_artes
        FROM usuarios u
        INNER JOIN artes a ON a.artista_id = u.id
        GROUP BY u.id
        ORDER BY total_artes DESC
        LIMIT 5";
$res = $conexao->query($sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $topPublicadores[] = $row;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ArtConnect - Painel Administrativo</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<?php include 'topo.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include 'navegacao.php'; ?>

    <main class="ml-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Painel Administrativo</h1>
        <h5 class="text-muted">Bem-vindo, <?php echo $_SESSION['NAME']; ?>!</h5>
      </div>

      <!-- Estatísticas -->
      <div class="row text-center">
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm border-primary">
            <div class="card-body">
              <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
              <h5 class="mt-2">Usuários</h5>
              <h3><?php echo $totalUsuarios; ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card shadow-sm border-success">
            <div class="card-body">
              <i class="bi bi-image-fill text-success" style="font-size: 2rem;"></i>
              <h5 class="mt-2">Artes</h5>
              <h3><?php echo $totalArtes; ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card shadow-sm border-info">
            <div class="card-body">
              <i class="bi bi-bookmarks-fill text-info" style="font-size: 2rem;"></i>
              <h5 class="mt-2">Tags</h5>
              <h3><?php echo $totalTags; ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card shadow-sm border-dark">
            <div class="card-body">
              <i class="bi bi-person-lines-fill text-dark" style="font-size: 2rem;"></i>
              <h5 class="mt-2">Equipe</h5>
              <h3><?php echo $totalFuncionarios; ?></h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Aniversariantes -->
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <i class="bi bi-cake-fill"></i> Aniversariantes do Mês - Usuários
            </div>
            <div class="card-body">
              <?php if (!empty($aniversariantesUsuarios)) { ?>
                <ul class="list-group">
                  <?php foreach ($aniversariantesUsuarios as $u) { ?>
                    <li class="list-group-item">
                      <?php echo $u['nome'] . " (" . $u['apelido'] . ") - " . date("d/m", strtotime($u['data_nascimento'])); ?>
                    </li>
                  <?php } ?>
                </ul>
              <?php } else { echo "<p>Nenhum aniversariante este mês.</p>"; } ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
              <i class="bi bi-cake2-fill"></i> Aniversariantes do Mês - Funcionários
            </div>
            <div class="card-body">
              <?php if (!empty($aniversariantesFuncionarios)) { ?>
                <ul class="list-group">
                  <?php foreach ($aniversariantesFuncionarios as $f) { ?>
                    <li class="list-group-item">
                      <?php echo $f['nome'] . " - " . $f['cargo'] . " - " . date("d/m", strtotime($f['data_nascimento'])); ?>
                    </li>
                  <?php } ?>
                </ul>
              <?php } else { echo "<p>Nenhum aniversariante este mês.</p>"; } ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Top publicadores -->
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
              <i class="bi bi-trophy-fill"></i> Usuários com Mais Artes Publicadas
            </div>
            <div class="card-body">
              <?php if (!empty($topPublicadores)) { ?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Apelido</th>
                      <th>Total de Artes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($topPublicadores as $t) { ?>
                      <tr>
                        <td><?php echo $t['nome']; ?></td>
                        <td><?php echo $t['apelido']; ?></td>
                        <td><?php echo $t['total_artes']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } else { echo "<p>Nenhum dado disponível.</p>"; } ?>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
