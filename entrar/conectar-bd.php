<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "cozinha_do_dia";

$con = new mysqli($host, $usuario, $senha, $banco);
if ($con->connect_error) {
    die("Erro na conexão com o banco de dados: " . $con->connect_error);
} else {
    echo "Conexão com o banco de dados estabelecida com sucesso.";
}


?>