<?php
require_once '../../../conexao.php';

if (!isset($_SESSION)) {
    session_start();
}

// CADASTRAR
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_usuario') {

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $apelido = mysqli_real_escape_string($conexao, $_POST['apelido']);
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    $status = 1;
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $sql = "INSERT INTO usuarios (id, nome, nome_social, email, senha, tipo, cpf, rg, data_nascimento, foto, status, data_cadastro, apelido, sexo) VALUES (0, '$nome', '$nome_social', '$email', '$senha', '$tipo', '$cpf', '$rg', '$data_nascimento', '$foto', '$status', NOW(), '$apelido', '$sexo')";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
        header('Location: editar-perfil.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar!";
        header('Location: editar-perfil.php');
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
    }
}

// ATUALIZAR
if (isset($_POST['atualizar']) && $_POST['atualizar'] == 'atualizar_usuario') {
    $status = mysqli_real_escape_string($conexao, $_POST['status']);
    $codigo = mysqli_real_escape_string($conexao, $_POST['id']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $apelido = mysqli_real_escape_string($conexao, $_POST['apelido']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    $sql = "UPDATE usuarios SET nome='$nome', nome_social='$nome_social', email='$email', tipo='$tipo', cpf='$cpf', rg='$rg', data_nascimento='$data_nascimento', apelido='$apelido', status='$status', sexo='$sexo', descricao='$descricao'";

    if (!empty($senha)) {
        $sql .= ", senha='$senha'";
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $pasta = '../../../images/perfil/';
        $arquivo_tmp = $_FILES['foto']['tmp_name'];
        $nome_arquivo = basename($_FILES['foto']['name']);
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $ext_permitidas)) {
            $novo_nome = $codigo . '_' . time() . '.' . $extensao;
            $destino = $pasta . $novo_nome;
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                $sql .= ", foto='$novo_nome'";
            } else {
                die("Erro ao mover o arquivo da foto.");
            }
        } else {
            die("Tipo de arquivo não permitido. Use JPG, PNG ou GIF.");
        }
    }

    $sql .= " WHERE id = $codigo";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        header('Location: editar-perfil.php');
        exit;
    } else {
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
    }
}

// EXCLUIR
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir_conta') {
    if (!isset($_SESSION['ID'])) {
        header("Location: ../../login/login.php");
        exit;
    }

    $codigo = intval($_SESSION['ID']);
    $sql = "DELETE FROM usuarios WHERE id = $codigo LIMIT 1";

    if (mysqli_query($conexao, $sql)) {
        session_unset();
        session_destroy();
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        header("Location: ../../login/login.php");
        exit;
    } else {
        die("Erro ao excluir usuário: " . mysqli_error($conexao));
    }
}
