<?php
require_once '../../../conexao.php';
if (!isset($_SESSION))
    session_start();

// Pega o ID do usuário da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = intval($_GET['id']);
} else {
    echo "ID do usuário não informado.";
    exit;
}

// Verifica se o visitante é o próprio usuário logado
$proprio_usuario = isset($_SESSION['ID']) && $_SESSION['ID'] == $id_usuario;

// Dados do usuário
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

// Busca contatos do artista
$sqlContatos = "SELECT id, nome, rede, status, url 
                FROM contato 
                WHERE artista_rede = $id_usuario";
$resContatos = mysqli_query($conexao, $sqlContatos);

// Lista de ícones locais
$redes_icones = [
    'discord' => '../../../images/icons/discord.png',
    'twitter' => '../../../images/icons/twitter.png',
    'instagram' => '../../../images/icons/instagram.png',
    'facebook' => '../../../images/icons/facebook.png',
    'telegram' => '../../../images/icons/telegram.png',
    'tiktok' => '../../../images/icons/tiktok.png',
    'youtube' => '../../../images/icons/youtube.png',
    'x' => '../../../images/icons/twitter.png',
    'e621' => '../../../images/icons/E621.png',
    'inkbunny' => '../../../images/icons/inkbunny.png',
    'whatsapp' => '../../../images/icons/whatsapp.png',
    'furaffinity' => '../../../images/icons/furaffinity.png',
    'pintrest' => '../../../images/icons/pintrest.png',
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Contatos - ArtConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../css/contatos.css">
    <link rel="icon" href="/artconnect/images/assets/img/logo.png" type="image/png">
</head>

<?php include("../../topo.php"); ?>

<body>
    <main class="container-usuario">
        <?php include("../navegacao.php"); ?>

        <section class="perfil-contatos">

            <div class="usuario-header">
                <img src="<?= !empty($usuario['foto'])
                    ? '../../../images/perfil/' . htmlspecialchars($usuario['foto'])
                    : '../../../images/assets/img/placeholder-funcionario.png' ?>" 
                    alt="Foto de perfil" class="foto-perfil">
                <div class="info-usuario">
                    <h2>@<?= htmlspecialchars($usuario['apelido']) ?></h2>
                    <p class="nome-real"><?= htmlspecialchars($usuario['nome']) ?></p>
                    <p class="descricao"><?= htmlspecialchars($usuario['descricao']) ?></p>
                </div>
            </div>

            <div class="titulo-barra">
                <h2>📱 Contatos</h2>
                <?php include '../../mensagem.php'; ?>
                <?php if ($proprio_usuario): ?>
                    <a href="inserir.php" class="btn-novo">+ Novo Contato</a>
                <?php endif; ?>
            </div>

            <?php if ($resContatos && mysqli_num_rows($resContatos) > 0): ?>
                <div class="grid-contatos">
                    <?php while ($c = mysqli_fetch_assoc($resContatos)): ?>
                        <?php
                        $rede_clean = strtolower(trim($c['rede']));
                        $rede_clean = preg_replace('/[^a-z0-9]/', '', $rede_clean);
                        $icone_path = $redes_icones[$rede_clean] ?? '../../../images/icons/default.png';
                        $url = !empty($c['url']) ? htmlspecialchars($c['url']) : '#';
                        ?>
                        <div class="card-contato">
                            <a href="<?= $url ?>" target="_blank" class="conteudo-card">
                                <img src="<?= $icone_path ?>" alt="<?= htmlspecialchars($c['rede']) ?>" class="icone-rede">
                                <div>
                                    <h4><?= htmlspecialchars($c['rede']) ?></h4>
                                    <p><?= htmlspecialchars($c['nome']) ?></p>
                                    <span class="status <?= $c['status'] == 0 ? 'inativo' : 'ativo' ?>">
                                        <?= $c['status'] == 0 ? 'Inativo' : 'Ativo' ?>
                                    </span>
                                </div>
                            </a>

                            <?php if ($proprio_usuario): ?>
                                <div class="acoes">
                                    <a href="editar.php?id=<?= $c['id'] ?>" class="btn editar">Editar</a>

                                    <form method="get" action="acoes.php" style="display:inline;">
                                        <button type="submit" name="excluir" value="<?= $c['id'] ?>" class="btn excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir?')">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="sem-contatos">Este usuário ainda não cadastrou contatos.</p>
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
