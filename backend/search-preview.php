<?php
session_start();

$endereco = $_SERVER['HTTP_HOST'];
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$url = $protocolo . $endereco;

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/configs.php';
    
    try {
        $conn = new mysqli($endereco, $usuario, $senha, $dtbs);
        if ($conn->connect_error) {
            throw new mysqli_sql_exception("Não foi possível se conectar ao banco de dados");
        }
    } catch (mysqli_sql_exception $e) {
        echo 'Não foi possivel conectar ao database';
        exit;
    } 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM posts WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $searchParam = '%' . $search . '%';
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='results'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='result' id='result' data-url='" . $url . '/' . 'search.php?query=' . $row['title'] . "'>";
            echo "<img src='" . $url . "/midia/icones/search.png' style='margin:20px; width:20px; height:20px;'> ";
            echo $row['title'];
            echo "</div>";
        }
        echo "</div>";
    } else {
        $one = true;
    }

  
    $sql = "SELECT * FROM users WHERE username LIKE ? AND UserStatus = 'active'";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!empty($row["profile_picture"])) {
                echo "<div class='result' id='result' data-url='" . $url . "/users/verUsuario.php?UserId=" . $row['Userid'] . "'>";
                echo "<img src='data:image/jpeg;base64," . $row["profile_picture"] . "' style='width:40px; height:40px;'> ";
            } else {
                echo "<div class='result' id='result' data-url='" . $url . "/users/verUsuario.php?UserId=" . $row['Userid'] . "'>";
                echo "<img src='data:image/jpeg;base64," . $row["default_picture"] . "' style='width:40px; height:40px;'> ";
            }

            echo $row["username"] . "<br>";
            echo "</div>";
        }
    } else {
        $two = true;
    }

    if (isset($one) && isset($two) && $one && $two) {
        echo "<div class='nothing-result' style='margin: 10px 20px; width:20px; height:20px;'>Nada encontrado</div>";
    }
    $stmt->close();
    $conn->close();
}
?>
<script>
    $(document).ready(function () {
        $('.result').on('click', function () {
            var url = $(this).data('url');
            window.location.href = url;
        });
    });
</script>
