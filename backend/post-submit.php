<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/backend/fx-verify.php';
if (isset($_POST['text_content'])) {


        if (isset($_POST['editing']) && $_POST['editing'] != null) {

            $Pageid = $_POST['editing'];


            $stmt = $database->prepare("UPDATE posts SET title = ?, description = ?, topic = ?, cover_image = ?, text_content = ?, CreatorId = ? WHERE Pageid = ?");
            $stmt->bind_param("sssssss", $title, $description, $topic, $imageData, $text_content, $Creator, $Pageid);


            $Creator = $UserId;
            $title = $_POST["title"];
            $description = $_POST["description"];
            $topic = $_POST["topic"];
            $base64 = $_POST['cover'];
            $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
            $imageData = base64_decode($base64);
            $text_content = $_POST["text_content"];
            $checkQuery = "SELECT Pageid FROM posts WHERE title = ? AND topic = ?";
            $checkStmt = $database->prepare($checkQuery);
            $checkStmt->bind_param("ss", $title, $topic);
            $checkStmt->execute();
            $checkStmt->store_result();
            
            $query = "SELECT topic, title FROM posts WHERE Pageid = '$Pageid'";
            $result = $database->query($query);
            $row = $result->fetch_assoc();

            if ($checkStmt->num_rows > 0 && $_POST['title'] != $row['title'] && $_POST['topic'] != $row['topic']) {
                echo json_encode(array('error' => true,'message' => 'Já existe um post com o mesmo título e tópico.'));
                exit;
            } else {
                    $stmt->execute();
                    echo json_encode(array('error' => false,'message' => 'Post atualizado'));
            }

        } else {


            $Pageid = uniqid();

            $stmt = $database->prepare("INSERT INTO posts (title, description, topic, cover_image, text_content, CreatorId, Pageid) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title, $description, $topic, $imageData, $text_content, $Creator, $Pageid);

            $Creator = $UserId;
            $title = $_POST["title"];
            $description = $_POST["description"];
            $topic = $_POST["topic"];
            $base64 = $_POST['cover'];
            $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
            $imageData = base64_decode($base64);
            $text_content = $_POST["text_content"];

            $checkQuery = "SELECT Pageid FROM posts WHERE title = ? AND topic = ?";
            $checkStmt = $database->prepare($checkQuery);
            $checkStmt->bind_param("ss", $title, $topic);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                echo json_encode(array('error' => true,'message' => 'Já existe um post com o mesmo título e tópico.'));
                exit;
            } else {

            $stmt->execute();
            echo json_encode(array('error' => false,'message' => 'Post enviado'));

            }

            $stmt->close();
            $database->close();
        }
    }
?>