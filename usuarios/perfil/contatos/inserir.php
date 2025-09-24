<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
    header('Location: ../../login/login.php');
    exit;
}

$id_usuario = $_SESSION['ID'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Contato - ArtConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="../../../css/adicionar_c.css">
    <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">

</head>
<?php include("../../topo.php"); ?>
<body>
<main class="container-usuario">
    <?php include("../navegacao.php"); ?>

    <section class="perfil-contatos">
            <?php include '../../mensagem.php'; ?>
        <h2>📱 Novo Contato</h2>
        <form action="acoes.php" method="post" class="form-contato">

            <input type="hidden" name="acao" value="inserir">

            <label for="nome">Nome do Contato:</label>
            <input type="text" name="nome" id="nome" required placeholder="Ex: João Silva">

            <label for="rede">Rede:</label>
            <input type="text" name="rede" id="rede" required maxlength="10" placeholder="Ex: Discord">

            <label for="url">Link do Perfil:</label>
            <input type="url" name="url" id="url" placeholder="Ex: https://discord.com/users/1234">

            <label for="status">Status:</label>
            <select name="status" id="status" disabled>
                <option value="1" selected >Ativo</option>
                <option value="0">Inativo</option>
            </select>

            <button type="submit" class="btn-novo">Salvar Contato</button>
        </form>
    </section>
</main>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<footer>
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>
</html>
