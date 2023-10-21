<?php
    include $_SERVER['DOCUMENT_ROOT'] . '\Trabalho_da_SEPE\templates\main.php';

    if (isset($_COOKIE['UserId'])) {
        if ($row['UserClass'] == 'adm'|| $row['UserClass'] == 'host') {
?>


<style>
    
    .conteudo2 {
        margin: 0 auto;
        max-width: 626px;
    }

    .Main-Grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(305px, 0fr));
        gap: 10px;
        justify-content: center;
    }

    .grid-item {
        background-color: #f2f2f2;
        padding: 20px;

        text-align: center;
    }

    .fg-sf {
        margin: auto;
        border: 1px solid #dadce0;
        width: 260px;
        height: 130px;
        border-radius: 8px;
        padding: 20px;
        cursor: pointer;
        font-family: sans-serif;
    }

    .fg-sf:hover {
        box-shadow: 0 1px 3px rgba(54, 64, 67, .3), 0 4px 8px 3px rgba(54, 64, 67, .15);
    }

    .date {
        color: #5f6368;
        font-size: 12px;
    }

    .fg-sf-title,
    .fg-sf-img {
        width: 49%;
        height: calc(100% - 14px);
        display: inline-block;
    }

    .fg-sg {
        margin: auto;
        display: flex;
        align-items: center;
        border: 1px solid #dadce0;
        width: 260px;
        height: 130px;
        border-radius: 8px;
        padding: 20px;
        cursor: pointer;
        font-family: sans-serif;
    }

    .fg-sg-img {
        height: 100%;
        display: inline-block;
    }

    .fg-sg-title {
        width: 48%;
        height: calc(100% - 14px);
        padding-left: 10px;
        display: flex;
        align-items: center;
    }

    .fg-sg:hover {
        box-shadow: 0 1px 3px rgba(54, 64, 67, .3), 0 4px 8px 3px rgba(54, 64, 67, .15);
    }

    #Creator_name:hover {
        text-decoration: underline !important;
    }
</style>
<div style="  
    padding: 13px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;">
    <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
    
</div>
<div class="Main-Grid">
   
      <div class="fg-sf results" data-url="<?php $url ?>/88/usuarios.php">
          <header class="date">
              <a id="Creator_name" style="color: #494949; text-decoration: none;" href=""></a><span
                  style="font-size: 11px;color: gray;"></span>
          </header>
          <div class="fg-sf-title"><span
                  style="float: left; padding: 6px 0; max-width: 100%;height: 90%; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">Administrar usuarios</span>
          </div>
          <div class="fg-sf-img">
              <img style="height: 100%; width: 100%; border-radius: 12px;object-fit: cover;" src="<?php echo $url ?>/midia/icones/admin-panel.png">
          </div>
      </div>
      <div class="fg-sf results" data-url="<?php echo $url . '/88/ver-posts.php?return=' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
          <header class="date">
              <a id="Creator_name" style="color: #494949; text-decoration: none;" href=""></a><span
                  style="font-size: 11px;color: gray;"></span>
          </header>
          <div class="fg-sf-title"><span
                  style="float: left; padding: 6px 0; max-width: 100%;height: 90%; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">Administrar postagens</span>
          </div>
          <div class="fg-sf-img">
              <img style="height: 100%; width: 100%; border-radius: 12px;object-fit: cover;" src="<?php echo $url ?>/midia/icones/write.png">
          </div>
      </div>
</div>

<script>

  $(document).ready(function () {
    $('.results').on('click', function () {
      var url = $(this).data('url');
      window.location.href = url;
    });
  });
</script>



<?php
    } else {
        echo 'Você não tem permissão para acessar esta pagina';
    }
} else {
    echo 'Você precisa fazer login para acessar esta pagina';
}
$database->close();
?>