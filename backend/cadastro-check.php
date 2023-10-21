<?php
session_start();
if(isset($_POST['code'])){
if ($_POST['code'] == $_SESSION['code']) {
    
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
    $fullname = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    $username = strtolower(trim($username));
 

    $codes = array();
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 0; $i < 3; $i++) {
        $code = '';
        for ($j = 0; $j < 25; $j++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        $code = preg_replace('/(.{5})(?=.)/', '$1-', $code);
        $codes[] = $code;
    }

    $width = 1000;
    $height = 1000;
    $colors = array(
        "azul" => array(50, 100, 200),
        "roxo" => array(150, 50, 200),
        "rosa" => array(255, 150, 180),
        "marrom claro" => array(205, 133, 63),
        "laranja" => array(255, 165, 0),
        "vermelho" => array(255, 0, 0),
        "verde" => array(0, 128, 0),
        "preto" => array(150, 150, 150),
        "magenta" => array(204, 0, 255),
        "ciano" => array(0, 238, 255)
    );
    $random_color = $colors[array_rand($colors)];
    $image = imagecreatetruecolor($width, $height);
    $background_color = imagecolorallocate($image, $random_color[0], $random_color[1], $random_color[2]);
    imagefill($image, 0, 0, $background_color);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $font_path = $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/roboto.ttf';
    $font_size = 400;
    $text_box = imagettfbbox($font_size, 0, $font_path, strtoupper(substr($username, 0, 1)));
    $text_width = $text_box[2] - $text_box[0];
    $text_height = $text_box[3] - $text_box[5];
    $text_x = round(($width - $text_width) / 2) - $text_box[0]; 
    $text_y = round(($height + $text_height) / 2);
    imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font_path, strtoupper(substr($username, 0, 1)));
    ob_start();
    imagepng($image);
    $image_data = ob_get_contents();
    ob_end_clean();
    $base64_image = base64_encode($image_data);
    imagedestroy($image);
  
    $Userid = uniqid();

    $UserStatus = 'active';
    $UserClass = 'user';
    $password = hash('sha256', $password);
    $LowerUsername = $username;
    $stmt = $database->prepare("INSERT INTO users (fullname, username, email, password, Userid, UserClass, UserStatus, upaxmn, upaymn, upazmn, default_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $fullname, $LowerUsername, $email, $password, $Userid, $UserClass, $UserStatus, $codes[0], $codes[1], $codes[2], $base64_image);
    $stmt->execute();
    $stmt->close();
    $database->close();
    echo 'email armazened';

    unset($_SESSION['fullname']); 
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['password']); 
} else {
    echo 'Codigo incorreto';
} 
}
?>