<?php

// Inclui o arquivo de conexão com o banco de dados
include "../conectar-bd.php";

$erros = [];

if (isset($_POST['nome'], $_POST['email-cadastro'], $_POST['senha-cadastro'], $_POST['confirma-senha'], $_POST['captcha'])) {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email_cadastro = $_POST['email-cadastro'];
    $senha_cadastro = $_POST['senha-cadastro'];
    $confirma_senha = $_POST['confirma-senha'];
    $captcha = $_POST['captcha'];
}

// Verifica se todos os campos foram preenchidos
if (empty($nome) || empty($email_cadastro) || empty($senha_cadastro) || empty($confirma_senha) || empty($captcha)) {
    $erros[] = "Todos os campos devem ser preenchidos.";
}

// Verifica se as senhas coincidem
if ($senha_cadastro !== $confirma_senha) {
    $erros[] = "As senhas não coincidem. Tente novamente.";
}

// Verifica se o email já está cadastrado
$verificar_email = "SELECT * FROM usuarios WHERE email='$email_cadastro'";
$resultado_email = $con->query($verificar_email);

if ($resultado_email->num_rows > 0) {
    $erros[] = "O email já está cadastrado. Use outro endereço de email.";
}

// Exibe os erros, se houver
if (!empty($erros)) {
    foreach ($erros as $erro) {
        echo $erro . "<br>";
    }
} else {
    // Criptografa a senha
    $senha_hash = password_hash($senha_cadastro, PASSWORD_BCRYPT);

    // Prepara e insere os dados do usuário no banco de dados
    $inserir_usuario = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email_cadastro', '$senha_hash')";

    session_start();
    // Verifica o captcha
    if ($_POST["captcha"] == $_SESSION["palavra"]) {
        // Executa a inserção no banco de dados
        if ($con->query($inserir_usuario) === TRUE) {
            header("Location: entrar.php?mensagem=success"); // Redireciona para página de entrar.php com mensagem de sucesso
            exit();
        } else {
            header("Location: entrar.php?mensagem=error"); // Redireciona para página de entrar.php com mensagem de erro
            exit();
        }
    } else {
        // Exibe mensagem de erro de captcha
        echo "<h1>Você não acertou o captcha!</h1>";
        echo "<a href='entrar.php'></a>";
    }
}
?>
