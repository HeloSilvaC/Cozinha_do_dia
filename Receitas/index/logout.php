<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Remover as variáveis de sessão
unset($_SESSION["estaLogado"]);
unset($_SESSION["nomeUsuario"]);

// Limpar o buffer de saída, se estiver sendo usado
ob_end_clean();

// Redirecionar para a página de login ou outra página desejada
$redirectLocation = "..\index\index.php"; // Substitua pelo redirecionamento desejado
header("Location: " . $redirectLocation);
exit();
?>
