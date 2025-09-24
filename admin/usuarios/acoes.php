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
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $apelido = mysqli_real_escape_string($conexao, $_POST['apelido']);
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    $status = 1;
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $sql = "INSERT INTO usuarios
        (id, nome, nome_social, email, senha, tipo, cpf, rg, data_nascimento, foto, status, data_cadastro, apelido, sexo)
        VALUES 
        (0, '$nome', '$nome_social', '$email', '$senha', '$tipo', '$cpf', '$rg', '$data_nascimento', '$foto', '$status', NOW(), '$apelido', '$sexo')";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
        header('Location: inserir.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar!";
        header('Location: inserir.php');
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
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
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
   

    $sql = "UPDATE usuarios SET nome ='$nome', nome_social = '$nome_social', email='$email', senha='$senha', tipo= $tipo, cpf= '$cpf', rg='$rg', data_nascimento ='$data_nascimento', apelido='$apelido', status= $status, sexo= '$sexo'";

    //VERIFICANDO SE O INPUT DA FOTO ESTA VAZIO
    if(!empty($foto)){
        $sql .=", foto = '$foto'";
    }

    $sql .= " WHERE id = $codigo";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Usuario atualizado com sucesso!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php');
    } else {
        // $_SESSION['mensagem'] = "Erro ao atualizar!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        // header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
    }
}
 if(isset($_POST['deletar']))
     {
            $codigo = $_POST['deletar'];
               
              $sql = "DELETE FROM usuario WHERE id = $codigo";
        if(mysqli_query($conexao, $sql))
        {
            $_SESSION['mensagem'] = "Usuário excluido com sucesso!"; 
            header('Location: index.php');
        }
        else{
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao));   
     }
     }
     ?>