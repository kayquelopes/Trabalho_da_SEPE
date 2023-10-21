<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/configs.php';

try {
    $database = new mysqli($endereco, $usuario, $senha, $dtbs);
    if ($database->connect_error) {
        throw new mysqli_sql_exception("Não foi possível se conectar ao banco de dados: " . $database->connect_error);
    }
} catch (mysqli_sql_exception $e) {
    echo 'Não foi possivel conectar ao database';
    exit;
} 
if (isset($_COOKIE['UserId'])) {
    $UserId = $_COOKIE['UserId'];
    $query = "SELECT * FROM users WHERE UserId='$UserId'";
    $results = mysqli_query($database, $query);
    $row = mysqli_fetch_assoc($results);
  
    if (isset($_COOKIE['upaxmn']) && (isset($_COOKIE['upaymn'])) && (isset($_COOKIE['upazmn']))) {
      
      if ($_COOKIE['upaxmn'] == $row['upaxmn'] && $_COOKIE['upaymn'] == $row['upaymn'] && $_COOKIE['upaxmn'] == $row['upaxmn']) {       

        if (isset($row['UserStatus']) && $row['UserStatus'] == "banned") {
          die('Usuario banido');
        }
      } else {
        die('Verificação de segurança falhou');
      }
    } else {
        die('Verificação de segurança falhou');
      }
} else {
    die('Você precisa estar logado');
}

$endereco = $_SERVER['HTTP_HOST'];
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$url = $protocolo . $endereco;

?>
