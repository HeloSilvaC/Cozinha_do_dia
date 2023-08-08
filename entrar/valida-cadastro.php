<?php

include "../conectar-bd.php";

$erros = [];

if (isset($_POST['nome'], $_POST['email-cadastro'], $_POST['senha-cadastro'], $_POST['confirma-senha'], $_POST['captcha'])) {

    $nome = $_POST['nome'];
    $email_cadastro = $_POST['email-cadastro'];
    $senha_cadastro = $_POST['senha-cadastro'];
    $confirma_senha = $_POST['confirma-senha'];
    $captcha = $_POST['captcha'];

}

if (empty($nome) || empty($email_cadastro) || empty($senha_cadastro) || empty($confirma_senha) || empty($captcha)) {
    $erros[] = "Todos os campos devem ser preenchidos.";
}

if ($senha_cadastro !== $confirma_senha) {
    $erros[] = "As senhas não coincidem. Tente novamente.";
}

$verificar_email = "SELECT * FROM usuarios WHERE email='$email_cadastro'";
$resultado_email = $con->query($verificar_email);

if ($resultado_email->num_rows > 0) {
    $erros[] = "O email já está cadastrado. Use outro endereço de email.";
} else {
    foreach ($erros as $erro) {
        echo $erro . "<br>";
    }
}

if (empty($erros)) {
    $senha_hash = password_hash($senha_cadastro, PASSWORD_BCRYPT); // Criptografa a senha usando Bcrypt

    $inserir_usuario = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email_cadastro', '$senha_hash')";

    session_start();
    if ($_POST["captcha"] == $_SESSION["palavra"]) {
        if ($con->query($inserir_usuario) === TRUE) {
            header("Location: entrar.php?mensagem=success"); // Redireciona para página de entrar.php com mensagem de sucesso
            exit();
        } else {
            header("Location: entrar.php?mensagem=error"); // Redireciona para página de entrar.php com mensagem de erro
            exit();
        }
    } else {
        echo "<h1>Você não acertou o captcha!</h1>";
        echo "<a href='entrar.php'></a>";
    }
} else {
    echo "Erro geral";
    exit();
}
?>
