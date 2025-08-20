<?php

require_once '../../conexao.php';
if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
    session_start();
}


if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_funcionario') {
    // 🔽 puxandoo id 🔽impedindo que tenha vazamento 🔽metodo pra pegar 🔽nome que damos no "name"
    $codigo_cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);
    $salario = str_replace(',', '.', $_POST['salario']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    //ENVIANDO A FOTO PARAO SERVIDOR
    //pegando o nome da imagem
    $foto = basename($_FILES['foto']['name']);
    //salvando o caminho temporario na pasta tmp
    $tmp = $_FILES['foto']['tmp_name'];
    //criando o caminho final da imagem
    $final = "../../images/perfil/" . $foto;
    //movendo a imagem da pasta temporaria para a pasta IMAGES
    move_uploaded_file($tmp, $final);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);
    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);
    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']);
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    // INSERT DO FUNCIONARIO
    $sql = "INSERT INTO funcionario VALUES( 0, '$nome', '$nome_social', '$data_nascimento', '$sexo', '$estado_civil', '$cpf', '$rg', '$salario', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$telefone_residencial', '$telefone_celular', '$email', 1, NOW(), '$usuario', '$senha', $tipo_acesso, '$foto', $codigo_cargo)";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Funcionario cadastrado com sucesso!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
        die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
    }
}

 
//ATUALIZAR FUNCIONARIO

if (isset($_POST['atualizar']) && $_POST['atualizar'] == 'atualizar_funcionario') {

    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_funcionario']);
    $status = mysqli_real_escape_string($conexao, $_POST['status']);
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);

    $salario = str_replace(',', '.', $_POST['salario']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_social = mysqli_real_escape_string($conexao, $_POST['nome_social']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $estado_civil = mysqli_real_escape_string($conexao, $_POST['estado_civil']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $telefone_residencial = mysqli_real_escape_string($conexao, $_POST['telefone_residencial']);
    $telefone_celular = mysqli_real_escape_string($conexao, $_POST['telefone_celular']);
    $tipo_acesso = mysqli_real_escape_string($conexao, $_POST['tipo_acesso']);
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $foto = basename($_FILES['foto']['name']);
    $tmp = $_FILES['foto']['tmp_name'];
    $final = "../../images/perfil/" . $foto;
    move_uploaded_file($tmp, $final);
}

    // INSERT DO FUNCIONARIO
    $sql = "UPDATE funcionario SET nome ='$nome', nome_social = '$nome_social', data_nascimento ='$data_nascimento', sexo= '$sexo', estado_civil='$estado_civil', cpf= '$cpf', rg='$rg', salario='$salario', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', cep='$cep', telefone_residencial= '$telefone_residencial', telefone_celular= '$telefone_celular', email='$email', status= $status, usuario= '$usuario', senha='$senha', tipo_acesso= $tipo_acesso, codigo_cargo=$cargo";

    //VERIFICANDO SE O INPUT DA FOTO ESTA VAZIO
    if (!empty($foto)) {
        $sql .= ", foto = '$foto'";
    }

    $sql .= " WHERE codigo_funcionario = $codigo";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Funcionario atualizado com sucesso!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
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
               


              $sql = "DELETE FROM funcionario WHERE codigo_funcionario= $codigo";
        if(mysqli_query($conexao, $sql))
        {
            $_SESSION['mensagem'] = "Funcionario excluido com sucesso!"; 
            header('Location: index.php');
        }
        else{
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao));   
     }
     }
     ?>