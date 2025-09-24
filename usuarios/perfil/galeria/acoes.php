<?php
session_start();
require_once '../../../conexao.php';

// ID do usuário logado, se houver
$id_usuario_logado = isset($_SESSION['ID']) ? $_SESSION['ID'] : 0;

// --- GET: Listar artes ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // ID do artista passado na URL
    $id_get = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $busca = isset($_GET['busca']) ? mysqli_real_escape_string($conexao, $_GET['busca']) : '';

    if ($id_get <= 0) {
        echo "<p style='text-align:center;'>Usuário inválido.</p>";
        exit;
    }

    // Consulta pelas artes do artista especificado na URL
    $where = "WHERE artista_id = $id_get";
    if ($busca) {
        $where .= " AND titulo LIKE '%$busca%'";
    }

    $sql = "SELECT * FROM artes $where ORDER BY data_publicacao DESC";
    $res = mysqli_query($conexao, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        echo "<p style='text-align:center;'>Nenhuma arte cadastrada.</p>";
        exit;
    }

    while ($arte = mysqli_fetch_assoc($res)) {
        $imagem = (!empty($arte['imagem']) && file_exists("../../../images/produtos/{$arte['imagem']}"))
            ? "../../../images/produtos/{$arte['imagem']}"
            : "../../../images/assets/img/placeholder-produto.jpg";

        $tags = [];
        $tagRes = mysqli_query($conexao, "SELECT t.nome FROM arte_tag at JOIN tags t ON at.tag_id = t.id WHERE at.arte_id = {$arte['id']}");
        while ($t = mysqli_fetch_assoc($tagRes)) {
            $tags[] = '#' . htmlspecialchars($t['nome']);
        }
        $tags_str = implode(' ', $tags);

        // É dono da arte apenas se o usuário logado for o dono
        $data_dono = ($arte['artista_id'] == $id_usuario_logado) ? 'true' : 'false';
        ?>
        <div class="card-arte"
             data-id="<?= $arte['id'] ?>"
             data-titulo="<?= htmlspecialchars($arte['titulo']) ?>"
             data-descricao="<?= htmlspecialchars($arte['descricao']) ?>"
             data-tags="<?= $tags_str ?>"
             data-preco="<?= number_format($arte['preco'], 2, ',', '.') ?>"
             data-imagem="<?= $imagem ?>"
             data-dono="<?= $data_dono ?>">
          <img src="<?= $imagem ?>" alt="<?= htmlspecialchars($arte['titulo']) ?>">
        </div>
        <?php
    }
    exit;
}

// --- POST: Cadastrar arte ---
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] === 'cadastrar_arte') {
    if ($id_usuario_logado <= 0) {
        $_SESSION['mensagem'] = "Você precisa estar logado para cadastrar uma arte.";
        exit;
    }

    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $preco = floatval(str_replace(',', '.', $_POST['preco']));
    $desconto = isset($_POST['desconto']) ? floatval(str_replace(',', '.', $_POST['desconto'])) : 0;
    $promocao = isset($_POST['promocao']) ? intval($_POST['promocao']) : 0;

    $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
    $preco_final = $preco - $preco_promocao;

    if ($preco_final < 0) {
        $_SESSION['mensagem'] = "Desconto inválido.";
        exit;
    }

    // Upload da imagem
    $imagem = '';
    if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === 0) {
        $imagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $destino = "../../../images/produtos/" . $imagem;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
    }

    $sql = "INSERT INTO artes (titulo, descricao, imagem, artista_id, preco, desconto, preco_promocao, preco_final, data_publicacao, promocao) 
            VALUES ('$titulo', '$descricao', '$imagem', $id_usuario_logado, $preco, $desconto, $preco_promocao, $preco_final, NOW(), $promocao)";
    if (mysqli_query($conexao, $sql)) {
        $arte_id = mysqli_insert_id($conexao);

        if (!empty($_POST['tags']) && is_array($_POST['tags'])) {
            foreach ($_POST['tags'] as $tag_id) {
                $tag_id = intval($tag_id);
                mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($arte_id, $tag_id)");
            }
        }

        $_SESSION['mensagem'] = "Arte cadastrada com sucesso!";
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar arte: " . mysqli_error($conexao);
        exit;
    }
}

// --- POST: Atualizar arte ---
if (isset($_POST['atualizar']) && $_POST['atualizar'] === 'atualizar_arte') {
    $id_arte = intval($_POST['id']);
    // Só permite atualizar se for dono da arte
    $check = mysqli_query($conexao, "SELECT id FROM artes WHERE id = $id_arte AND artista_id = $id_usuario_logado");
    if (mysqli_num_rows($check) === 0) {
        $_SESSION['mensagem'] = "Você não tem permissão para editar esta arte.";
        exit;
    }

    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $preco = floatval(str_replace(',', '.', $_POST['preco']));
    $desconto = floatval(str_replace(',', '.', $_POST['desconto']));
    $promocao = isset($_POST['promocao']) ? intval($_POST['promocao']) : 0;

    $preco_promocao = ($desconto > 0) ? $preco * ($desconto / 100) : 0;
    $preco_final = $preco - $preco_promocao;

    if ($preco_final < 0) {
        $_SESSION['mensagem'] = "Desconto inválido.";
        exit;
    }

    $imagem = isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0
        ? uniqid() . '_' . basename($_FILES['imagem']['name'])
        : mysqli_real_escape_string($conexao, $_POST['imagem_atual']);

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../../../images/produtos/" . $imagem);
    }

    // Atualiza tags
    if (isset($_POST['tags']) && is_array($_POST['tags'])) {
        mysqli_query($conexao, "DELETE FROM arte_tag WHERE arte_id = $id_arte");
        foreach ($_POST['tags'] as $tag_id) {
            $tag_id = intval($tag_id);
            mysqli_query($conexao, "INSERT INTO arte_tag (arte_id, tag_id) VALUES ($id_arte, $tag_id)");
        }
    }

    $sql = "UPDATE artes SET titulo = '$titulo', descricao = '$descricao', preco = $preco, desconto = $desconto, preco_promocao = $preco_promocao, preco_final = $preco_final, promocao = $promocao, imagem = '$imagem' WHERE id = $id_arte AND artista_id = $id_usuario_logado";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Arte atualizada com sucesso!";
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar arte: " . mysqli_error($conexao);
        exit;
    }
}

// --- POST: Excluir arte ---
if (isset($_POST['deletar'])) {
    $id_arte = intval($_POST['deletar']);
    $check = mysqli_query($conexao, "SELECT id FROM artes WHERE id = $id_arte AND artista_id = $id_usuario_logado");
    if (mysqli_num_rows($check) === 0) {
        $_SESSION['mensagem'] = "Você não tem permissão para excluir esta arte.";
        exit;
    }

    $sql = "DELETE FROM artes WHERE id = $id_arte AND artista_id = $id_usuario_logado";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Arte excluída com sucesso!";
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir arte: " . mysqli_error($conexao);
        exit;
    }
}
?>
