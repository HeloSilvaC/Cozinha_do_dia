<?php
session_start();

include "../conectar-bd.php";

if (isset($_POST['email-login']) && isset($_POST['senha-login'])) {
    $email_login = $_POST['email-login'];
    $senha_login = md5($_POST['senha-login']);

    // Consulta SQL para verificar o login
    $sql = "SELECT * FROM usuarios WHERE email='$email_login' AND senha='$senha_login'";

    // Execute a consulta
    $result = $con->query($sql);

    // Verifique se há um único resultado correspondente
    if ($result->num_rows == 1) {
        // Login bem-sucedido

        // Recupere os dados do usuário
        $linha = $result->fetch_assoc();

        // Defina as variáveis de sessão para manter o usuário logado
        $_SESSION["id"] = $linha["id"];
        $_SESSION["estaLogado"] = true;

       
        header("Location: ../index/index.php");
        exit();
    } else {
        // Login falhou
        $erro = "Credenciais inválidas. Verifique seu email e senha.";
    }
}

?>