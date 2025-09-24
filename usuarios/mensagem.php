<?php
if (isset($_SESSION['mensagem'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    echo htmlspecialchars($_SESSION['mensagem']);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>';
    echo '</div>';

    unset($_SESSION['mensagem']);
}
?>
