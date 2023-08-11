<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Remover as variáveis de sessão
unset($_SESSION["estaLogado"]);
unset($_SESSION["nomeUsuario"]);

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login ou outra página desejada
header("Location: ../entrar/entrar.php"); // Substitua pelo redirecionamento desejado
exit();
?>
