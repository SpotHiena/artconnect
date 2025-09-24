<?php
//CONEXÃO COM O BANCO DE DADOS
require_once '../../conexao.php';; //O 'require_once' BUSCA UMA VEZ SÓ A INFORMAÇÃO - JÁ O 'require' BUSCA INFINITAMENTE

if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
    session_start();
}
//CADASTRAR UM NOVO CARGO
if (isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'cadastrar_cargo') //'isset' VERIFICA SE CHEGOU O 'input hidden' - SE CHEGOU ARMAZENA NA VARIÁVEL
{
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']); //'mysqli_real_escape_string' MANDA AS INFORMAÇÕES PARA O BANCO FORMATADA DE UMA MANEIRA QUE O BANCO ENTENDA
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']); //'mysqli_real_escape_string' MANDA AS INFORMAÇÕES PARA O BANCO FORMATADA DE UMA MANEIRA QUE O BANCO ENTENDA

    $sql = "INSERT INTO cargo VALUES (0, '$cargo', '$observacao', 1, NOW())";

    if (mysqli_query($conexao, $sql)) {
        //header('Location: index.php');

        $_SESSION['mensagem'] = "Cargo cadastrado com sucesso!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
    } else {
        //die("Erro: " . $sql . "<br>" . mysqli_error($conexao)); - ESSE CÓDIGO MOSTRA O ERRO

        $_SESSION['mensagem'] = "Erro ao cadastrar!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
    }
}


// ATUALIZAR

if (!isset($_SESSION)) //SE NÃO FOI SETADO UMA SEÇÃO, INICIE UMA
{
    session_start();
}
//CADASTRAR UM NOVO CARGO
if (isset($_POST['atualizar']) && $_POST['atualizar'] == 'atualizar_cargo') //'isset' VERIFICA SE CHEGOU O 'input hidden' - SE CHEGOU ARMAZENA NA VARIÁVEL
{
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']); //'mysqli_real_escape_string' MANDA AS INFORMAÇÕES PARA O BANCO FORMATADA DE UMA MANEIRA QUE O BANCO ENTENDA
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']); //'mysqli_real_escape_string' MANDA AS INFORMAÇÕES PARA O BANCO FORMATADA DE UMA MANEIRA QUE O BANCO ENTENDA
    $status = mysqli_real_escape_string($conexao, $_POST['status']);
    $codigo = mysqli_real_escape_string($conexao, $_POST['codigo_cargo']);

    $sql = "UPDATE cargo SET nome='$cargo', observacao='$observacao', status= $status";

    $sql .= " WHERE codigo_cargo = $codigo";

    if (mysqli_query($conexao, $sql)) {
        //header('Location: index.php');

        $_SESSION['mensagem'] = "Cargo atualizado com sucesso!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
    } else {
        //die("Erro: " . $sql . "<br>" . mysqli_error($conexao)); - ESSE CÓDIGO MOSTRA O ERRO

        $_SESSION['mensagem'] = "Erro ao atualizar!"; //ESSA VARIÁVEL SESSION FOI CRIADA NA PASTA MENSAGEM
        header('Location: inserir.php'); //APÓS O CADASTRO PERMANECE NA MESMA PÁGINA
    }
}

if (isset($_POST['deletar'])) {
    $codigo = $_POST['deletar'];

    $sql_verifica = "SELECT cargo.nome FROM cargo INNER JOIN funcionario ON cargo.codigo_cargo = funcionario.codigo_cargo WHERE cargo.codigo_cargo = $codigo";
    $query = mysqli_query($conexao, $sql_verifica);
    $contagem = mysqli_num_rows($query);

    if ($contagem > 0) {
        $_SESSION['mensagem'] = "Não é possivel excluir o cargo <b>" . $cargo['nome'] . "</b> pois existe(m) <b>" . $contagem . " funcionario(s) </b> vinculados a ele";
        header('Location: index.php');
    } else {
        $sql = "DELETE FROM cargo WHERE codigo_cargo = $codigo";
        if (mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = "Cargo excluido com sucesso!";
            header('Location: index.php');
        } else {
            die("Erro: " . $sql . "<br>" . mysqli_error($conexao));
        }
    }
}
