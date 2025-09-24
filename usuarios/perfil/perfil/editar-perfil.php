<?php
session_start();
require_once '../../../conexao.php';

// Verifica login
if (!isset($_SESSION['ID'])) {
    header("Location: ../../login/login.php");
    exit;
}

$id_usuario = $_SESSION['ID'];

// Busca dados do usuário
$sql = "SELECT * FROM usuarios WHERE id = $id_usuario LIMIT 1";
$res = mysqli_query($conexao, $sql);
if (!$res || mysqli_num_rows($res) === 0) {
    die("Usuário não encontrado.");
}
$usuario = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="../../../css/ediar.css" />
       <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<body class="bg-light">

    <header>
        <?php include("../../topo.php"); ?>
    </header>

    <div class="container py-4">

        <!-- SETA DE VOLTAR E TÍTULO -->
        <div class="d-flex align-items-center mb-3">
            <a href="../../perfil/perfil/usuario.php?id=<?= $_SESSION['ID'] ?>" class="btn-voltar me-3" title="Voltar para Perfil">&#8592;</a>

            <h2 class="m-0">Editar Perfil</h2>
        </div>

        <form action="acoes.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <?php include '../../mensagem.php'; ?>
            <!-- ESSENCIAIS PARA AÇÕES.PHP -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
            <input type="hidden" name="atualizar" value="atualizar_usuario">
            <!-- PRECISA MANDAR O STATUS, MESMO SE NÃO FOR EDITÁVEL -->
            <input type="hidden" name="status" value="<?= htmlspecialchars($usuario['status']) ?>">
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($usuario['tipo']) ?>">

            <!-- Foto de Perfil -->
            <div class="mb-3 text-center">
                <img id="preview"
                    src="<?= !empty($usuario['foto']) ? '../../../images/perfil/' . htmlspecialchars($usuario['foto']) : '../../../assets/img/user-placeholder.png' ?>"
                    class="rounded-circle mb-3" width="120" height="120" alt="Foto de Perfil">
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

            <!-- Nome -->
            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>"
                    required>
            </div>

            <!-- Nome Social -->
            <div class="mb-3">
                <label class="form-label">Nome Social</label>
                <input type="text" name="nome_social" class="form-control"
                    value="<?= htmlspecialchars($usuario['nome_social']) ?>">
            </div>

            <!-- Apelido -->
            <div class="mb-3">
                <label class="form-label">Apelido</label>
                <input type="text" name="apelido" class="form-control"
                    value="<?= htmlspecialchars($usuario['apelido']) ?>">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>"
                    required>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($usuario['cpf']) ?>">
            </div>

            <!-- RG -->
            <div class="mb-3">
                <label class="form-label">RG</label>
                <input type="text" name="rg" class="form-control" value="<?= htmlspecialchars($usuario['rg']) ?>">
            </div>

            <!-- Data de Nascimento -->
            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="data_nascimento" class="form-control"
                    value="<?= htmlspecialchars($usuario['data_nascimento']) ?>">
            </div>

            <!-- Sexo -->
            <div class="mb-3">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select">
                    <option value="M" <?= $usuario['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= $usuario['sexo'] === 'F' ? 'selected' : '' ?>>Feminino</option>
                    <option value="O" <?= $usuario['sexo'] === 'O' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>

            <!-- Senha -->
            <div class="mb-3">
                <label class="form-label">Nova Senha</label>
                <input type="password" name="senha" class="form-control" placeholder="Deixe em branco para não alterar">
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control"
                    rows="4"><?= htmlspecialchars($usuario['descricao'] ?? '') ?></textarea>
            </div>


            <!-- Botões -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="acoes.php?acao=excluir_conta" class="btn btn-danger"
                    onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')">
                    Excluir Conta
                </a>
            </div>

        </form>
    </div>


    <script src="../../../js/script.js"></script>
    <script src="../../../js/imagem.js"></script>

</body>
<footer class="bg-rose text-white py-3 text-center rounded-top">
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>
 <!-- jS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</html>