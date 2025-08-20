<?php
require_once '../../conexao.php';

 include_once '../usuario_admin.php';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Connect - Tags</title>

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->
    <link href="../../css/dashboard.css" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
</head>

<body>

    <?php include('../topo.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include('../navegacao.php'); ?>

            <main class="ml-auto col-lg-10 px-md-4">

                <div class="container mt-5">

                    <!-- MENSAGEM -->
                    <?php include '../mensagem.php'; ?>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Atualizar Tag</h4>

                            <a href="index.php" class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-left"></i> Voltar
                            </a>
                        </div>
                        <?php //<- PHP 'LA EM CIMA '
                        if (isset($_GET['id']) && $_GET['id'] != '') {
                            $codigo = $_GET['id'];
                            $sql = "SELECT * FROM tags WHERE id = $codigo";
                            $query = mysqli_query($conexao, $sql);
                            $tags = mysqli_fetch_assoc($query);
                        ?>

                            <div class="card-body">
                                <form action="acoes.php" method="post">
                                    <div class="form-row mb-3">
                                        <div class="col-md-6">
                                            <label for="nome"><strong class="text-danger">*</strong> Nome da Tag:</label>
                                            <input type="text" name="nome" class="form-control" maxlength="50" value="<?php echo $tags['nome'] ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="status"><strong class="text-danger">*</strong> Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="1" <?php if ($tags['status'] == 1) echo 'selected' ?>>Ativo</option>
                                                <option value="0" <?php if ($tags['status'] == 0) echo 'selected' ?>>Inativo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="atualizar" value="atualizar_tags">
                                    <input type="hidden" name="id" value="<?php echo $codigo ?>">
                                    <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                                </form>
                            </div>
                    </div>
                <?php
                        } //<- SERVE PRA FECHAR O IF DO PHP LA EM CIMA
                        else {
                            echo "<h5>Funcionario não encontrado<h5>";
                        }
                ?>

                </div>
            </main>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>

</html>