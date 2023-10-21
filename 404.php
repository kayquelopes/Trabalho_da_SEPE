<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';
?>
<style>
    #div-main-404{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    #img-main-404{
        height: 200px;
    }

</style>

<div id="div-main-404">
<a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
    <img id="img-main-404" src="<?php echo $url ?>/midia/icones/404.png">
    <span>404 - Pagina não encontrada</span>
</div>
