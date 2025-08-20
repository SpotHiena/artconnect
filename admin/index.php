<?php
require_once '../conexao.php';
if (!isset($_SESSION)) {
    session_start();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ArtConnect - Login</title>

    <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" />

 
</head>

<body class="text-center">
  <canvas></canvas>


  <div class="tool-box">
    <button class="button__tool" data-action="brush">
      <span class="material-symbols-outlined">brush</span>
    </button>
    <button class="button__tool" data-action="rubber">
      <span class="material-symbols-outlined">ink_eraser</span>
    </button>
    <button class="button__tool">
      <input type="color" class="input__color">
    </button>
  </div>

  <div class="tool-box">
    <button class="button__size" data-size="5"><span class="stroke"></span></button>
    <button class="button__size active" data-size="10"><span class="stroke"></span></button>
    <button class="button__size" data-size="20"><span class="stroke"></span></button>
    <button class="button__size" data-size="30"><span class="stroke"></span></button>
  </div>

  <div class="tool-box">
    <button class="button__tool button__clear">
      <span class="material-symbols-outlined">delete</span>
    </button>
    <button class="button__undo">
      <span class="material-symbols-outlined">undo</span>
    </button>
    <button class="button__redo">
      <span class="material-symbols-outlined">redo</span>
    </button>
    <button class="button__save">
      <span class="material-symbols-outlined">file_save</span>
    </button>
  </div>

  <main class="form-signin">
    <form action="login.php" method="POST">
      <h2 class="h3 mb-3">Faça seu Login</h2>
      <input type="text" class="form-control mb-2" name="usuario" placeholder="Usuário">
      <input type="password" class="form-control" name="senha" placeholder="Senha">
      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
    </form>

    <div class="pt-2">
      <?php
      if (isset($_SESSION['loginVazio'])) {
        echo '<div class="alert alert-warning alert-danger fade show" role="alert">';
        echo $_SESSION['loginVazio'];
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        unset($_SESSION['loginErro']);
      }

      if (isset($_SESSION['loginErro'])) {
        echo '<div class="alert alert-warning alert-danger fade show" role="alert">';
        echo $_SESSION['loginErro'];
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        unset($_SESSION['loginErro']);
      }

      if (isset($_SESSION['naoAutorizado'])) {
        echo '<div class="alert alert-warning alert-danger fade show" role="alert">';
        echo $_SESSION['naoAutorizado'];
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        unset($_SESSION['naoAutorizado']);
      }

      if (isset($_SESSION['logOff'])) {
        echo '<div class="alert alert-warning alert-success fade show" role="alert">';
        echo $_SESSION['logOff'];
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        unset($_SESSION['logOff']);
      }
      ?>
    </div>

    <p class="mt-5 text-muted">&copy; <?= date('Y') ?> ArtConnect</p>
  </main>

  <!-- Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <!-- JS CANVAS -->
  <script src="../js/login.js"></script>
</body>
</html>
