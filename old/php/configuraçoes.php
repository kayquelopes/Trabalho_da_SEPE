<?php

// Banco de Dados
$endereco = "sepe.hythelis.me";
$usuario = "sepe";
$senha = "SepeSenha123@";
$dtbs = "sepe";

try {
        $database = new mysqli($endereco, $usuario, $senha, $dtbs);
        if ($database->connect_error) {
            throw new mysqli_sql_exception($database->connect_error);
        }
    } catch (mysqli_sql_exception $e) {
        echo 'Não foi possivel conectar ao database Erro:' . $e . '"';
        exit;
    }
    
    $endereco = $_SERVER['HTTP_HOST'];
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $url = $protocolo . $endereco;
?>
