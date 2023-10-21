<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';

if (isset($_GET['query'])) {
  echo '<script>
    var SearchQuery = document.getElementById("search");
    SearchQuery.value = "' . $_GET['query'] . '";

    window.onload = function () { var titulo = document.title; var adicional = "' . $_GET['query'] . '"; document.title = titulo + " - " + adicional; }

    </script>';
} else {
  echo '
    <script>
    window.onload = function () { var titulo = document.title; var adicional = "Pesquisar"; document.title = titulo + " - " + adicional; }
    </script>';
}

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
<?php
if (isset($_GET['query'])) {
  $SearchQuery = $_GET['query'];
  $sqlSearch = "
    SELECT UserId, username, profile_picture, default_picture, NULL AS PageId, NULL AS title, NULL AS cover_image, NULL AS topic, NULL AS CreatorId, NULL AS data
    FROM users
    WHERE username LIKE '%$SearchQuery%'
    UNION
    SELECT NULL AS UserId, NULL AS username, NULL AS profile_picture, NULL AS default_picture, PageId, title, cover_image, topic, CreatorId, data
    FROM posts
    WHERE title LIKE '%$SearchQuery%'
    ORDER BY
        CASE
            WHEN username LIKE '%$SearchQuery%' THEN 1
            WHEN title LIKE '%$SearchQuery%' THEN 2
        END,
        CASE
            WHEN username LIKE '%$SearchQuery%' THEN LOCATE('$SearchQuery', username)
            WHEN title LIKE '%$SearchQuery%' THEN LOCATE('$SearchQuery', title)
        END
";

  $resultSearch = $database->query($sqlSearch);
  ?>
  
  <div class="Main-Grid">
  <?php
  if ($resultSearch->num_rows > 0) {
    while ($row = $resultSearch->fetch_assoc()) {
      if (!is_null($row['username'])) {
        echo '
            <div class="fg-sg results" data-url="' . $url . '/users/verUsuario.php?UserId=' . $row['UserId'] .  '">

              <div class="fg-sg-img">';
        if (!empty($row["profile_picture"])) {
          echo "<img style='height: 100%; border-radius: 50%;' src='data:image/jpeg;base64," . $row["profile_picture"] . "' style='width:40px; height:40px;'> ";
        } else {
          echo "<img style='height: 100%; border-radius: 50%;' src='data:image/jpeg;base64," . $row["default_picture"] . "' style='width:40px; height:40px;'> ";
        }
        echo '  
              </div>
              <div class="fg-sg-title">
                  <div style="max-width: 105%;"><span style="padding: 6px 0; height: 90%; max-width: 100%; overflow: hidden; text-overflow: ellipsis;">' . $row['username'] . '</span></div>
              </div>
    
          </div>
            
            
            ';

      } else if (!is_null($row['title'])) {
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
        echo '<div class="fg-sf results" data-url="' . $url . '/' . 'posts/verPost.php?PageId=' . $row['PageId'] . '">
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

    }
    echo '</div>';
  } else {
    echo "Nenhum resultado encontrado.";
  }
} else {
  echo "Nenhum resultado encontrado.";
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