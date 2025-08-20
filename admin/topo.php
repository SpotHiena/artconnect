<?php

   $url_completa = $_SERVER['REQUEST_URI'];

   $url_dividida = parse_url($url_completa);

   $caminho = explode ('/', $url_dividida['path']);

  $url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $caminho[1] . "/" . $caminho[2] . "/";


?>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 px-3" href="http://localhost/artconnect/admin/admin.php">ArtConnect</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href=" <?php echo $url?>logoff.php" onclick="return confirm('Tem certeza que deseja sair?')">Sair</a>
    </div>
  </div>
</header>