<?php

if (isset($_SESSION['mensagem'])) //se chegou no servidor uma variável mensagem faça...
{
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';

    echo $_SESSION['mensagem'];

    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

    unset($_SESSION['mensagem']);
}
