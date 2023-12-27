<?php
session_start();

// Remover as variáveis de sessão
unset($_SESSION["estaLogado"]);
unset($_SESSION["nomeUsuario"]);
 
// Limpar o buffer de saída
ob_end_clean();

// Redirecionar para a página de login
$redirectLocation = "../index/index.php";
header("Location: " . $redirectLocation);
exit();
?>