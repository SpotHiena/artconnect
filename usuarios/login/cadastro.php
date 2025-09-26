<?php
require_once '../../conexao.php';
if (!isset($_SESSION)) {
  session_start();
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ArtConnect - Cadastro</title>

  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" />
   <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
  <style>
    body {
      background: transparent;
    }

    .titulo-cadastro {
      font-size: 2.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 25px;
      color: black;
    }

    .form-signin {
      position: relative;
      z-index: 10;
      max-width: 600px;
      margin: 0 auto;
      margin-top: 6vh;
    }

    .form-quadrado {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .form-row {
      display: flex;
      gap: 10px;
    }

    .form-row .col {
      flex: 1;
    }

    .form-control {
      border-radius: 5px !important;
      height: 38px;
      font-size: 0.9rem;
      padding: 6px 10px;
    }

    button[type="submit"] {
      height: 42px;
      font-size: 1rem;
      border-radius: 5px;
    }

    .cadastro-link {
      font-size: 14px;
      margin-top: 8px;
    }

    .cadastro-link a {
      font-weight: bold;
      color: black;
      text-decoration: none;
    }

    .cadastro-link a:hover {
      text-decoration: underline;
    }

    p.text-muted {
      font-size: 13px;
    }
  </style>
</head>

<body class="text-center">
  <canvas></canvas>

  <!-- Ferramentas do Canvas -->
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
    <button class="button__tool button__clear"><span class="material-symbols-outlined">delete</span></button>
    <button class="button__undo"><span class="material-symbols-outlined">undo</span></button>
    <button class="button__redo"><span class="material-symbols-outlined">redo</span></button>
    <button class="button__save"><span class="material-symbols-outlined">file_save</span></button>
  </div>

  <main class="form-signin">
    <div class="titulo-cadastro">Cadastre-se</div>

    <?php if (isset($_SESSION['mensagem'])): ?>
      <div class="alert alert-info p-2">
        <?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?>
      </div>
    <?php endif; ?>

    <form action="acoes.php" method="post" enctype="multipart/form-data">

     <div class="form-row justify-content-center mb-3">
  <div class="col-auto text-center">
    <label for="foto" style="display:block; cursor:pointer; position: relative;">
      <div style="width:120px; height:120px; border-radius:50%; overflow:hidden; margin:0 auto; border:2px dashed #ccc; display:flex; align-items:center; justify-content:center; background:#f5f5f5;">
        <img id="preview" src="#" alt="Preview da imagem"
          style="width:100%; height:100%; object-fit:cover; display:none;">
        <span id="placeholder" style="font-size:12px; color:#888; position:absolute;">Clique para adicionar</span>
      </div>
    </label>
    <input type="file" class="form-control" name="foto" id="foto" accept="image/*" style="display:none;"
      onchange="preview.src=window.URL.createObjectURL(this.files[0]); preview.style.display='block'; document.getElementById('placeholder').style.display='none';">
  </div>
</div>


      <!-- Resto do formulário -->
      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
        </div>
        <div class="col">
          <input type="text" class="form-control" name="nome_social" placeholder="Nome social (opcional)">
        </div>
      </div>

      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" name="apelido" placeholder="Apelido" required>
        </div>
        <div class="col">
          <input type="password" class="form-control" name="senha" placeholder="Senha" required>
        </div>
      </div>

      <input type="email" class="form-control" name="email" placeholder="E-mail" required>

      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" name="cpf" placeholder="CPF" data-mask="000.000.000-00" required>
        </div>
        <div class="col">
          <input type="text" class="form-control" name="rg" placeholder="RG" data-mask="00.000.000-A" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col">
          <input type="date" class="form-control" name="data_nascimento" required>
        </div>
        <div class="col">
          <select class="form-control" name="sexo" required>
            <option value="">Sexo</option>
            <option value="F">Feminino</option>
            <option value="M">Masculino</option>
            <option value="O">Outro</option>
          </select>
        </div>
      </div>

      <div class="form-row">
  <div class="col">
    <input type="text" class="form-control" name="cidade" placeholder="Cidade">
  </div>
  <div class="col">
    <label for="estado"><strong class="text-danger">*</strong>Estado:</label>
    <select name="estado" id="estado" class="form-control" required>
      <option value=""></option>
      <option value="AC">AC</option>
      <option value="AL">AL</option>
      <option value="AP">AP</option>
      <option value="AM">AM</option>
      <option value="BA">BA</option>
      <option value="CE">CE</option>
      <option value="DF">DF</option>
      <option value="ES">ES</option>
      <option value="GO">GO</option>
      <option value="MA">MA</option>
      <option value="MT">MT</option>
      <option value="MS">MS</option>
      <option value="MG">MG</option>
      <option value="PA">PA</option>
      <option value="PB">PB</option>
      <option value="PR">PR</option>
      <option value="PE">PE</option>
      <option value="PI">PI</option>
      <option value="RJ">RJ</option>
      <option value="RN">RN</option>
      <option value="RS">RS</option>
      <option value="RO">RO</option>
      <option value="RR">RR</option>
      <option value="SC">SC</option>
      <option value="SP">SP</option>
      <option value="SE">SE</option>
      <option value="TO">TO</option>
    </select>
  </div>
</div>


      <div class="form-row">
        <div class="col">
          <textarea class="form-control" name="descricao" placeholder="Descrição sobre você" rows="3"></textarea>
        </div>
      </div>

      <!-- Campos fixos da tabela -->
      <input type="hidden" name="tipo" value="0">
      <input type="hidden" name="status" value="1">
      <input type="hidden" name="data_cadastro" value="<?= date('Y-m-d') ?>">

      <button class="w-25 btn btn-primary mt-2 d-block mx-auto" type="submit">Cadastrar</button>
      <input type="hidden" name="cadastrar" value="cadastrar_usuario">
      <div class="cadastro-link">
        Já possui uma conta? <a href="login.php">Faça Login</a>
      </div>
    </form>

    <p class="mt-4 text-muted">&copy; <?= date('Y') ?> ArtConnect</p>
  </main>

  <?php
  if (isset($_SESSION['mensagem'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    echo $_SESSION['mensagem'];
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    unset($_SESSION['mensagem']);
  }
  ?>

  <!-- Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <!-- Canvas -->
  <script src="../../js/login.js"></script>
  <script src="../../js/jquery.mask.js"></script>
  <script src="../../js/imagem.js"></script>
</body>

</html>
