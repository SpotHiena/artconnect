<?php
session_start();
require_once '../../../conexao.php';

if (!isset($_SESSION['ID'], $_SESSION['USER'])) {
    header('Location: ../../login/login.php');
    exit;
}

$id_usuario = $_SESSION['ID'];

// Pega contato antes de renderizar o HTML
$contato = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_contato = intval($_GET['id']);
    $sql = "SELECT * FROM contato WHERE id = $id_contato AND artista_rede = $id_usuario LIMIT 1";
    $res = mysqli_query($conexao, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $contato = mysqli_fetch_assoc($res);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Contato - ArtConnect</title>
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

        <h2>📱 Editar Contato</h2>

        <?php if (!$contato): ?>
            <p>Contato não encontrado ou você não tem permissão para editar.</p>
        <?php else: ?>
            <form action="acoes.php" method="post" class="form-contato">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" value="<?php echo (int)$contato['id']; ?>">

                <label for="nome">Nome do Contato:</label>
                <input type="text" name="nome" id="nome" required
                       value="<?php echo htmlspecialchars($contato['nome'], ENT_QUOTES); ?>">

                <label for="rede">Rede:</label>
                <input type="text" name="rede" id="rede" required maxlength="10"
                       value="<?php echo htmlspecialchars($contato['rede'], ENT_QUOTES); ?>">

                <label for="url">Link do Perfil:</label>
                <input type="url" name="url" id="url"
                       value="<?php echo htmlspecialchars($contato['url'], ENT_QUOTES); ?>">

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="1" <?php echo ($contato['status'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                    <option value="0" <?php echo ($contato['status'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                </select>

                <button type="submit" class="btn-novo">Salvar Alterações</button>
            </form>
        <?php endif; ?>

    </section>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

<footer>
    <p class="mb-0">&copy; 2025 Art Connect - Todos os direitos reservados</p>
</footer>
</html>
