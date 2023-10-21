<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/configs.php';

$database = new mysqli($endereco, $usuario, $senha, $dtbs);

if ($database->connect_error) {
    die("Falha na conexão com o banco de dados: " . $database->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {


$Pageid = $_GET['pagina_id'];

function contarAcoesPagina($commentId, $acao)
            {
                global $database;

                $sql = "SELECT COUNT(*) AS total FROM likes_dislikes WHERE Page_id = '$commentId' AND acao = '$acao'";
                $result = mysqli_query($database, $sql);

                $row = mysqli_fetch_assoc($result);
                return $row["total"];
            }
            function buscarAcaoUsuarioPagina($commentId, $userId)
            {
                global $database;

                $sql = "SELECT acao FROM likes_dislikes WHERE Page_id = '$commentId' AND user_id = '$userId'";
                $result = mysqli_query($database, $sql);

                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    return $row["acao"];
                }

                return null;
            }    



            $numLikesPagina = contarAcoesPagina($Pageid, 'like');
            $numDislikesPagina = contarAcoesPagina($Pageid, 'dislike');

            if (isset($_COOKIE['UserId'])) {
                $userId = $_COOKIE['UserId'];
                $userAction = buscarAcaoUsuarioPagina($Pageid, $userId);

                echo "<div class='acoes-usuario'>";
                echo "<button class='like-btn " . ($userAction === 'like' ? 'acao-usuario' : '') . "' data-type='pagina' data-comment-id='" . $Pageid . "'>Like</button>";
                echo "<span> " . $numLikesPagina . " |  " . $numDislikesPagina . " </span>";
                echo "<button class='dislike-btn " . ($userAction === 'dislike' ? 'acao-usuario' : '') . "' data-type='pagina' data-comment-id='" . $Pageid . "'>Dislike</button>";
                echo "</div>";
            } else {
                echo "<div class='acoes-usuario'>";
                echo "<button class='like-btn' data-type='pagina' data-comment-id='" . $Pageid . "'>Like</button>";
                echo "<span> " . $numLikesPagina . " |  " . $numDislikesPagina . " </span>";
                echo "<button class='dislike-btn' data-type='pagina' data-comment-id='" . $Pageid . "'>Dislike</button>";
                echo "</div>";
            }
        }
    ?>