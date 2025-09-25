<?php
require_once '../../conexao.php';
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_usuario') {

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    
    // TIPO FIXO = 1 (bit)
    $tipo = 1;

    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $apelido = mysqli_real_escape_string($conexao, $_POST['apelido']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $status = 1;
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $status = 1;
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    if (!empty($foto)) {
        $caminho_destino = '../../images/perfil/' . $foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_destino);
    }

    $verificaEmail = "SELECT id FROM usuarios WHERE email = '$email'";
    $resultadoEmail = mysqli_query($conexao, $verificaEmail);

    if (mysqli_num_rows($resultadoEmail) > 0) {
        $_SESSION['mensagem'] = "E-mail já cadastrado!";
        header('Location: cadastro.php');
        exit;
    }

    $verificaCpf = "SELECT id FROM usuarios WHERE cpf = '$cpf'";
    $resultadoCpf = mysqli_query($conexao, $verificaCpf);

    if (mysqli_num_rows($resultadoCpf) > 0) {
        $_SESSION['mensagem'] = "CPF já cadastrado!";
        header('Location: cadastro.php');
        exit;
    }

    $sql = "INSERT INTO usuarios
        (id, nome, nome_social, email, senha, tipo, cpf, rg, data_nascimento, foto, status, data_cadastro, apelido, sexo, descricao, cidade, estado)
        VALUES 
        (0, '$nome', '$nome_social', '$email', '$senha', $tipo, '$cpf', '$rg', '$data_nascimento', '$foto', $status, NOW(), '$apelido', '$sexo', '$descricao', '$cidade', '$estado')";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
        header('Location: cadastro.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar!";
        header('Location: cadastro.php');
        die("Erro: " . mysqli_error($conexao));
    }
}

//ATUALIZAR
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
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';

    $sql = "UPDATE usuarios SET nome ='$nome', nome_social = '$nome_social', email='$email', senha='$senha', tipo= $tipo, cpf= '$cpf', rg='$rg', data_nascimento ='$data_nascimento', apelido='$apelido', status= $status, sexo= '$sexo', descricao='$descricao'";

    //VERIFICANDO SE O INPUT DA FOTO ESTA VAZIO
    if (!empty($foto)) {
        $sql .= ", foto = '$foto'";
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

// DELETAR USUÁRIO
if (isset($_POST['deletar'])) {
    $codigo = mysqli_real_escape_string($conexao, $_POST['deletar']);
    $sql = "DELETE FROM usuarios WHERE id = $codigo";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        header('Location: editar-perfil.php');
        exit;
    } else {
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
    }
}
?>
