<?php
require_once '../../conexao.php';

 include_once '../usuario_admin.php';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro de Arte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico">
</head>

<style>
    .imagem-perfil {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        padding-top: 0;
        margin-top: -5px;
    }

    .imagem-perfil img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 5px;
    }

    .imagem-perfil input[type="file"] {
        width: auto;
    }
</style>

<body>
    <?php include('../topo.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include('../navegacao.php'); ?>


            <main class="ml-sm-auto col-lg-8 px-md-4 mt-5 d-flex justify-content-between align-items-center">
                <div class="card">
                    <?php include '../mensagem.php'; ?>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="m-0">Cadastro de Arte</h4>
                        <a href="index.php" class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>

                    <?php
                    if (isset($_GET['id']) && $_GET['id'] != '') {
                        $codigo = $_GET['id'];
                        $sql = "SELECT a.*, t.id AS tag_id, t.nome AS tag_nome FROM artes a LEFT JOIN arte_tag at ON at.arte_id = a.id LEFT JOIN tags t ON t.id = at.tag_id WHERE a.id = $codigo";
                        $query = mysqli_query($conexao, $sql);
                        $artes = mysqli_fetch_assoc($query);
                    ?>

                        <div class="card-body">
                            <form action="acoes.php" method="post" enctype="multipart/form-data">
                                <img id="preview"
                                    src="<?php echo !empty($artes['imagem']) ? '../../images/produtos/' . $artes['imagem'] : '../../assets/img/default.jpg'; ?>"
                                    alt="imagem" width="100px" height="100px">
                                <input type="hidden" name="imagem_atual" value="<?php echo $artes['imagem']; ?>">
                                <input type="file" name="imagem" id="imagem" class="form-control-file mb-2"
                                    accept="image/*">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="titulo">Título:</label>
                                        <input type="text" name="titulo" class="form-control"
                                            value="<?php echo $artes['titulo'] ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tags">Tags:</label>
                                        <select name="tags[]" id="tags" class="form-control select2" multiple>
                                            <?php
                                            // ESSE AQI É PRA BUSCAR AS TAGS DISPONIVEIS
                                            $tags_query = mysqli_query($conexao, "SELECT id, nome FROM tags");

                                            // ESSA DAQUI É UMA VARIAVEL PARA PEGAR AS TAGS QUE ESTAO VINCULADAS A UMA ARTE
                                            $tags_selecionadas = [];
                                            $res_tags_arte = mysqli_query($conexao, "SELECT tag_id FROM arte_tag WHERE arte_id = $codigo");
                                            while ($tag = mysqli_fetch_assoc($res_tags_arte)) {
                                                $tags_selecionadas[] = $tag['tag_id'];
                                            }

                                            // ESSE É SO O OPTION
                                            while ($tag = mysqli_fetch_assoc($tags_query)) {
                                                $selected = in_array($tag['id'], $tags_selecionadas) ? 'selected' : '';
                                                echo "<option value=\"{$tag['id']}\" $selected>{$tag['nome']}</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="descricao">Descrição:</label>
                                        <textarea name="descricao" class="form-control"
                                            rows="2"><?php echo $artes['descricao'] ?></textarea>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="preco">Preço de Venda:</label>
                                        <input type="text" name="preco" id="preco" class="form-control"
                                            data-mask="000000,00" data-mask-reverse="true"
                                            value="<?php echo $artes['preco'] ?>">
                                    </div>
                                </div>

                                <div class="form-row align-items-end">
                                    <div class="form-row align-items-end">
                                        <div class="form-group col-md-3">
                                            <label>Promoção?</label><br>    

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="promocao" id="promocao_sim" value="1" <?php if ($artes['promocao'] == 1) echo 'checked' ?>>
                                                <label class="form-check-label" for="promocao_sim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="promocao" id="promocao_nao" value="0" <?php if ($artes['promocao'] == 0) echo 'checked' ?>>
                                                <label class="form-check-label" for="promocao_nao">Não</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="desconto">% Desconto:</label>
                                        <div class="input-group">
                                            <input type="text" name="desconto" id="desconto" class="form-control"
                                                value="<?php echo $artes['desconto'] ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="preco_final">Preço Final:</label>
                                        <input type="text" id="preco_final" class="form-control"
                                            value="<?php echo $artes['preco_final'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <strong id="mensagem_erro" class="form-text text-danger" style="display: none;">* O
                                            desconto não pode ser maior que o preço!</strong>
                                    </div>
                                </div>

                                <input type="hidden" name="atualizar" value="atualizar_arte">
                                <input type="hidden" name="id" value="<?php echo $codigo ?>">
                                <input type="submit" value="Atualizar" class="btn btn-primary mt-3">
                            </form>
                        </div>
                    <?php
                    } else {
                        echo "<h5>Arte não encontrado<h5>";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../../js/jquery.mask.js"></script>
    <script src="../../js/conta.js"></script>

</body>

</html>