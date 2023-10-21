<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/configs.php';

$database = new mysqli($endereco, $usuario, $senha, $dtbs);

if ($database->connect_error) {
    die("Falha na conexão com o banco de dados: " . $database->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    function imprimirComentario($comentario, $comentarios, $nivel = 0)
    {
        global $database;

        $CreatorQuery = "SELECT * FROM users WHERE UserId = '" . $comentario["CreatorId"] . "'";
        $resultCreator = mysqli_query($database, $CreatorQuery);
        $rowCreator = mysqli_fetch_assoc($resultCreator);

        if (!empty($rowCreator["profile_picture"])) {
            $creator_image = $rowCreator["profile_picture"];
        } else {
            $creator_image = $rowCreator["default_picture"];
        }

        echo "<div style=' margin-left: " . ($nivel * 20) . "px;'>";

        $dataHora = new DateTime($comentario['data_publicacao']);
        $dataFormatada = $dataHora->format("d/m/y G:i");

        if (isset($_COOKIE['UserId']) && $_COOKIE['UserId'] == $comentario["CreatorId"]) {
            echo "<p class='creator-alguma-coisa'><img class='img-creator-alguma-coisa'  src='data:image/jpeg;base64," . $creator_image . "'> " . $rowCreator["username"] . " - Publicado em: " . $dataFormatada . "<button class='delete-btn' data-comment-id='" . $comentario["comment_id"] . "'>Deletar</button>" . "</p>";
        } else {
            echo "<p class='creator-alguma-coisa'><img class='img-creator-alguma-coisa'  src='data:image/jpeg;base64," . $creator_image . "'> " . $rowCreator["username"] . " - Publicado em: " . $dataFormatada . "</p>";
        }
        echo '<span style="line-break: anywhere;">' . $comentario["comentario"] . '</span></p>';

        $numLikes = contarAcoes($comentario["comment_id"], 'like');
        $numDislikes = contarAcoes($comentario["comment_id"], 'dislike');

        if (isset($_COOKIE['UserId'])) {
            $userId = $_COOKIE['UserId'];
            $userAction = buscarAcaoUsuario($comentario["comment_id"], $userId);

            echo "<div class='acoes-usuario'>";
            echo "<button class='like-btn " . ($userAction === 'like' ? 'acao-usuario' : '') . "' data-type='comentario' data-comment-id='" . $comentario["comment_id"] . "'>Like</button>";
            echo "<span> " . $numLikes . " |  " . $numDislikes . " </span>";
            echo "<button class='dislike-btn " . ($userAction === 'dislike' ? 'acao-usuario' : '') . "' data-type='comentario' data-comment-id='" . $comentario["comment_id"] . "'>Dislike</button>";
            echo "</div>";
        } else {
            echo "<div class='acoes-usuario'>";
            echo "<button class='like-btn' data-type='comentario' data-comment-id='" . $comentario["comment_id"] . "'>Like</button>";
            echo "<span> " . $numLikes . " |  " . $numDislikes . " </span>";
            echo "<button class='dislike-btn' data-type='comentario' data-comment-id='" . $comentario["comment_id"] . "'>Dislike</button>";
            echo "</div>";
        }




        if (isset($comentarios[$comentario["comment_id"]])) {
            echo "<button class='mostrar-respostas-btn' data-comment-id='" . $comentario["comment_id"] . "'>Mostrar Respostas</button>";
            echo "<div class='respostas' id='respostas-" . $comentario["comment_id"] . "' style='display: none;'>";
            foreach ($comentarios[$comentario["comment_id"]] as $resposta) {
                imprimirComentario($resposta, $comentarios, $nivel + 1);
            }
            echo "</div>";
        }
        if (isset($_COOKIE['UserId'])) {
        echo "<button class='responder-btn' data-comment-id='" . $comentario["comment_id"] . "'>Responder</button>";
        echo "<div class='resposta-form' id='resposta-" . $comentario["comment_id"] . "' style='display: none;'>";
        echo "<form id='resposta-formulario' data-parent-id='" . $comentario["comment_id"] . "'>";
        echo "<textarea placeholder='Sua resposta' required></textarea>";
        echo "<button type='submit'>Enviar Resposta</button>";
        echo "</form></div>";
        }

        echo "</div>";
    }

    function buscarAcaoUsuario($commentId, $userId)
    {
        global $database;

        $sql = "SELECT acao FROM likes_dislikes WHERE comentario_id = '$commentId' AND user_id = '$userId'";
        $result = mysqli_query($database, $sql);

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            return $row["acao"];
        }

        return null;
    }

    function contarAcoes($commentId, $acao)
    {
        global $database;

        $sql = "SELECT COUNT(*) AS total FROM likes_dislikes WHERE comentario_id = '$commentId' AND acao = '$acao'";
        $result = mysqli_query($database, $sql);

        $row = mysqli_fetch_assoc($result);
        return $row["total"];
    }



    $pagina_id = $_GET["pagina_id"];

    $sql = "SELECT * FROM comentarios WHERE pagina_id = '$pagina_id' AND CommentStatus = 'active'";
    $resultado = mysqli_query($database, $sql);

    $comentarios = array();

    while ($row = mysqli_fetch_assoc($resultado)) {
        $comentarios[$row["parent_id"]][] = $row;
    }

    if (isset($comentarios['']) && count($comentarios['']) > 0) {
        foreach ($comentarios[''] as $comentario) {
            imprimirComentario($comentario, $comentarios);
        }
    } else {
        echo "Nenhum comentário encontrado.";
    }


    mysqli_close($database);
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['type']) && $_POST['type'] == 'exclude') {
        if (isset($_POST['commentId'])) {
          
            $commentId = $_POST['commentId'];

            $deleteSql = "UPDATE comentarios SET CommentStatus = 'deleted' WHERE comment_id = '$commentId' OR parent_id  = '$commentId'";
            if ($database->query($deleteSql) === TRUE) {

                echo 'Comentario excluido';
            } else {

                echo 'Não foi possivel excluir o comentario';
            }

        }
    } else {
        $CreatorId = $_COOKIE['UserId'];
        $comentario = $_POST["comentario"];
        $pagina_id = $_POST["pagina_id"];
        if (isset($_POST["parent_id"]) && $_POST["parent_id"] != null) {
            $parent_id = $_POST["parent_id"];
        } else {
            $parent_id = null;
        }
        $comment_id = uniqid();

        $sql = "INSERT INTO comentarios (comment_id, parent_id, CreatorId, comentario, pagina_id, CommentStatus) VALUES ('$comment_id', '$parent_id', '$CreatorId', '$comentario', '$pagina_id', 'active')";

        if (mysqli_query($database, $sql)) {
            echo "Comentário adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar comentário: " . mysqli_error($database);
        }

        mysqli_close($database);
    }
}
?>