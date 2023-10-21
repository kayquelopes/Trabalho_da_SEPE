<?php
session_start();

require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$hashpass = hash('sha256', $password);

$query = "SELECT * FROM users WHERE email='$email' OR username='$username' OR password='$hashpass'";
$result = mysqli_query($database, $query);

if (mysqli_num_rows($result) > 0) {
 
    $row = mysqli_fetch_assoc($result);
    if ($row['email'] === $email) {
        echo "Error: Email";
    } else if($row['username'] === $username){
        echo "Error: Username";
    } else if($row['password'] === $hashpass){ 
        echo "O usuario {$row['username']} já esta utilizando esta senha";
    }
} else {
    $mail = new PHPMailer(true);

    try {
    
        $code = rand(100000, 999999);
        $_SESSION['code'] = $code;

       
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'mail.sepe@hythelis.me'; 
        $mail->Password = 'SepeSenha123@';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mail.sepe@hythelis.me', 'Geo World - Autentificacao de email');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Autenticar email';
        $mail->Body = 'seu codigo de autentificacao: ' . $code;

        $mail->send();

        echo "Email envied";
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
