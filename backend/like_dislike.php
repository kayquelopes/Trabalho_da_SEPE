<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/configs.php';

$database = new mysqli($endereco, $usuario, $senha, $dtbs);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_COOKIE['UserId'])) {
       
       if(isset($_POST['type']) && $_POST['type'] == 'comentario'){

        $type = 'comentario';
        $page_id = $_POST["comment_id"];
        $action = $_POST["action"];
        $userId = $_COOKIE['UserId']; 

        $sql = "SELECT acao FROM likes_dislikes WHERE comentario_id = '$page_id' AND user_id = '$userId'";
        $result = mysqli_query($database, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $existingAction = $row["acao"];
        } 
        else{
            $existingAction = null;
        }
        
        
    
        if ($existingAction === null) {
        
            $sql = "INSERT INTO likes_dislikes (user_id, tipo, comentario_id, acao) VALUES ('$userId', '$type', '$page_id', '$action')";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação registrada com sucesso!";
            } else {
                echo "Erro ao registrar ação: " . mysqli_error($database);
            }
        } elseif ($existingAction !== $action) {
           
            $sql = "UPDATE likes_dislikes SET acao = '$action' WHERE user_id = '$userId' AND comentario_id = '$page_id' ";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar ação: " . mysqli_error($database);
            }
        } else {
            
            $sql = "DELETE FROM likes_dislikes WHERE user_id = '$userId' AND comentario_id = '$page_id'";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação removida com sucesso!";
            } else {
                echo "Erro ao remover ação: " . mysqli_error($database);
            }
        }
    } else if(isset($_POST['type']) && $_POST['type'] == 'pagina'){

        $type = 'pagina';
        $page_id = $_POST["comment_id"];
        $action = $_POST["action"];
        $userId = $_COOKIE['UserId']; 

        $sql = "SELECT acao FROM likes_dislikes WHERE Page_id = '$page_id' AND user_id = '$userId'";
        $result = mysqli_query($database, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $existingAction = $row["acao"];
        } 
        else{
            $existingAction = null;
        }
        
        
    
        if ($existingAction === null) {
        
            $sql = "INSERT INTO likes_dislikes (user_id, tipo, Page_id, acao) VALUES ('$userId', '$type', '$page_id', '$action')";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação registrada com sucesso!";
            } else {
                echo "Erro ao registrar ação: " . mysqli_error($database);
            }
        } elseif ($existingAction !== $action) {
           
            $sql = "UPDATE likes_dislikes SET acao = '$action' WHERE user_id = '$userId' AND Page_id = '$page_id' ";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar ação: " . mysqli_error($database);
            }
        } else {
            
            $sql = "DELETE FROM likes_dislikes WHERE user_id = '$userId' AND Page_id = '$page_id'";
            
            if (mysqli_query($database, $sql)) {
                echo "Ação removida com sucesso!";
            } else {
                echo "Erro ao remover ação: " . mysqli_error($database);
            }
        }

    }
        
        

    } else {
        echo "Usuário não autenticado.";
    }

    
}

?>
