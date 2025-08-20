<?php 
  $url_completa = $_SERVER['REQUEST_URI']; //ELE PEGA TODA A URL DEPOIS DO 'localhost'

  $url_dividida = parse_url($url_completa); //CAMINHO DA URL

  $caminho = explode('/', $url_dividida['path']); //DIVIDE A URL

  $url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $caminho[1] . "/"; //REMONTANDO A URL

  $paginaAtual = $_SERVER['REQUEST_URI'];
?>


<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
  <div class="position-sticky pt-3">
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>OPÇÕES</span>
    </h6>
    
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($paginaAtual, 'admin.php') !== false) ? 'active' : ''; ?>" href="<?php echo $url?>admin/admin.php">
          <i class="bi bi-house-door-fill"></i>
          Início
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($paginaAtual, '/admin/cargos') !== false) ? 'active' : ''; ?>" href="<?php echo $url?>admin/cargos">
          <i class="bi bi-person-fill-gear"></i>
          Cargos
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($paginaAtual, '/funcionarios') !== false) ? 'active' : ''; ?>" href="<?php echo $url?>admin/funcionarios">
          <i class="bi bi-people-fill"></i>
          Funcionários
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($paginaAtual, '/usuarios') !== false) ? 'active' : ''; ?>" href="<?php echo $url?>admin/usuarios">
          <i class="bi bi-people-fill"></i>
          Usuarios
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($paginaAtual, '/admin/Tags') !== false) ? 'active' : ''; ?>" href="<?php echo $url?>admin/Tags">
          <i class="bi bi-stack"></i>
          Tags
        </a>
      </li>

    </ul>
  </div>
</nav>