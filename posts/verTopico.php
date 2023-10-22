<?php
//copyright Matheus Lopes
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';
if (isset($_GET['TopicoName']) && $_GET['TopicoName'] != null) {
    $TopicoName = $_GET['TopicoName'];

    $query = "SELECT * FROM posts WHERE topic = '$TopicoName'";
    $resultPost = mysqli_query($database, $query);
    if ($resultPost->num_rows > 0) {


        ?>

        <style>
            @media (max-width: 690px) {
                .conteudo2 {
                    max-width: 626px;
                }
            }

            .conteudo2 {
                margin: 0 auto;
                max-width: 935px;
            }

            .Main-Grid {
                display: flex;
                gap: 10px;
                justify-content: center;
                flex-wrap: wrap;
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
            <span>Todos os posts do topico
                <?php echo $TopicoName; ?>
            </span>
        </div>
        <div class="Main-Grid">
            <?php

            while ($row = $resultPost->fetch_assoc()) {
                $dataHora = new DateTime($row['data']);
                $meses = array(
                    1 => "Janeiro",
                    2 => "Fevereiro",
                    3 => "Março",
                    4 => "Abril",
                    5 => "Maio",
                    6 => "Junho",
                    7 => "Julho",
                    8 => "Agosto",
                    9 => "Setembro",
                    10 => "Outubro",
                    11 => "Novembro",
                    12 => "Dezembro"
                );
                $dataFormatada = $dataHora->format("d \d\\e ") . $meses[$dataHora->format("n")] . $dataHora->format(" G:i");
                $query_creator = "SELECT * FROM users WHERE userid = '" . $row['CreatorId'] . "'";
                $result_creator = $database->query($query_creator);
                $row_creator = $result_creator->fetch_assoc();
                echo '<div class="fg-sf results" data-url="' . $url . '/' . 'posts/verPost.php?PageId=' . $row['Pageid'] . '">
          <header class="date">
              <a id="Creator_name" style="color: #494949; text-decoration: none;" href="' . $url . '/users/verUsuario.php?UserId=' . $row_creator['Userid'] . '">' . $row_creator['username'] . '</a><span
                  style="font-size: 11px;color: gray;"> &bull; ' . $dataFormatada . '</span>
          </header>
          <div class="fg-sf-title"><span
                  style="float: left; padding: 6px 0; max-width: 100%;height: 90%; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">' . $row['title'] . '</span>
          </div>
          <div class="fg-sf-img">
              <img style="height: 100%; width: 100%; border-radius: 12px;object-fit: cover;" src="data:image/jpeg;base64,' . base64_encode($row["cover_image"]) . '">
          </div>
      </div>';


            }

    } else {
        echo 'Topico não encotrado';
    }

} else {
    echo 'Topico a visualizar não selecionado';
}
?>
<script>
    $(document).ready(function () {
        $('.results').on('click', function () {
            var url = $(this).data('url');
            window.location.href = url;
        });
    });
</script>
<?php
//copyright Matheus Lopes
?>