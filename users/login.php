<?php

require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
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

$endereco = $_SERVER['HTTP_HOST'];
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$url = $protocolo . $endereco;


    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
 
        $return_url = isset($_GET['return']) ? $_GET['return'] : $url;
        header("Location: $return_url");
        exit;
    } elseif (isset($_POST['username']) && isset($_POST['password'])) {
        

        $HashUsername = strtolower(trim($_POST['username']));
        $username = mysqli_real_escape_string($database, $HashUsername);
        $password = mysqli_real_escape_string($database, $_POST['password']);
        $password = hash('sha256', $password);


        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($database, $query);

        if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_assoc($results);

            setcookie('loggedin', true, time() + (86400 * 30), "/");
            setcookie('UserId', $row['Userid'], time() + (86400 * 30), "/");
            setcookie('upaxmn', $row['upaxmn'], time() + (86400 * 30), "/");
            setcookie('upaymn', $row['upaymn'], time() + (86400 * 30), "/");
            setcookie('upazmn', $row['upazmn'], time() + (86400 * 30), "/");

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.zoho.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mail.sepe@hythelis.me';
                $mail->Password = 'SepeSenha123@';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('mail.sepe@hythelis.me', 'Geo World - Login detectado');
                $mail->addAddress($row['email']);

                $mail->isHTML(true);
                $mail->Subject = 'Novo Login';
                $mail->Body = 'Novo login detectado na sua conta <br>
                Ip: ' . $_SERVER['REMOTE_ADDR'];

                $mail->send();

                echo "Email envied";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }

            $return_url = isset($_GET['return']) ? $_GET['return'] : $url;
            header("Location: $return_url");
            exit;
        } else {
            echo "<script> alert('Nome ou senha inválidos'); </script>";
        }
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php'; 
?>
    
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var loginElement = document.getElementById('login');
            if (loginElement) {
                loginElement.style.display = 'none';
            }
        });
        window.onload = function () { var titulo = document.title; var adicional = "Fazer Login"; document.title = titulo + " - " + adicional; }

    </script>
    <style>
        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: center;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="login-container">
        <h1>Login</h1>
        <form class="login-form" method="POST" onsubmit="showLoadingScreen()">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" placeholder="Digite seu usuário" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>
            <button class="login-btn" type="submit">Entrar</button>
            <a href="<?php $url ?>/users/cadastro.php" style="color: #555555; margin: 10px auto 0 auto;">Cadastre-se</a>
        </form>
    </div>
    


    </body>

    </html>