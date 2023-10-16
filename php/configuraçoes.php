<?php

// Banco de Dados
$endereco = "sepe.hythelis.me";
$usuario = "sepe";
$senha = "SepeSenha123@";
$dtbs = "sepe";

try {
        $database = new mysqli($endereco, $usuario, $senha, $dtbs);
        if ($database->connect_error) {
            throw new mysqli_sql_exception("Não foi possível se conectar ao banco de dados: " . $database->connect_error);
        }
    } catch (mysqli_sql_exception $e) {
        echo 'Não foi possivel conectar ao database Erro:' . $e . '"';
        exit;
    }
    
?>