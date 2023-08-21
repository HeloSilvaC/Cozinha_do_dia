<?php
session_start();

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "../conectar-bd.php";

    if (isset($_POST['email-login']) && isset($_POST['senha-login'])) {
        $email_login = $_POST['email-login'];
        $senha_login = $_POST['senha-login'];

        // Consulta SQL para verificar o login
        $sql = "SELECT * FROM usuarios WHERE email='$email_login'";

        // Execute a consulta
        $result = $con->query($sql);

        // Verifique se há um único resultado correspondente
        if ($result->num_rows == 1) {
            $linha = $result->fetch_assoc();
            
            // Verifique a senha usando password_verify
            if (password_verify($senha_login, $linha['senha'])) {
                ob_clean(); // Limpar o buffer de saída
                
                // Defina as variáveis de sessão e redirecione
                $_SESSION["id"] = $linha["id"];
                $_SESSION["estaLogado"] = true;
                $_SESSION["nomeUsuario"] = $linha["nome"]; // Obtém o nome do usuário do banco de dados
            
                header("Location: ../index/index.php");
                exit();
            }
             else {
                // Senha incorreta
                $erro = "Credenciais inválidas. Verifique sua senha.";
            }
        } else {
            // Usuário não encontrado
            $erro = "Credenciais inválidas. Verifique seu email e senha.";
        }
    }
}
?>
