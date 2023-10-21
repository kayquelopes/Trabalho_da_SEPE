<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/backend/fx-verify.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $post_id = $_POST["id"];

        $query = "SELECT topic, title FROM posts WHERE Pageid = '$post_id'";
        $result = $database->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

                $sqlComment = "SELECT * FROM comentarios WHERE pagina_id = '$post_id'";
                $resultComment = $database->query($sqlComment);
                while ($rowInner = mysqli_fetch_assoc($resultComment)) {
                    $sqlCommentInner = "DELETE FROM likes_dislikes WHERE comentario_id = '" . $rowInner['comment_id'] . "'";
                    $database->query($sqlCommentInner);
                }

                $sqlLikesDislikes = "DELETE FROM likes_dislikes WHERE Page_id = '$post_id'";
                $database->query($sqlLikesDislikes);

                $sqlComment = "DELETE FROM comentarios WHERE pagina_id = '$post_id'";
                $database->query($sqlComment);



                $sql = "DELETE FROM posts WHERE Pageid = '$post_id'";
                if ($database->query($sql) === TRUE) {
                    echo "success";
                } else {
                    echo "error";
                }
            
        }

        $database->close();
    }
}
?>
