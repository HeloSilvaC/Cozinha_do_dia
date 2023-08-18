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
        $mensagem = "Erro ao inserir usuário:\n" . $erros;
        header("Location: entrar.php?mensagem=" . urlencode($mensagem)); // Redireciona para index.php com a mensagem
        exit();
    }
} else {
    // Criptografa a senha
    $senha_hash = password_hash($senha_cadastro, PASSWORD_BCRYPT);

    // Prepara e insere os dados do usuário no banco de dados
    $inserir_usuario = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email_cadastro', '$senha_hash')";

    session_start();
    // Verifica o captcha
    if ($_POST["captcha"] == $_SESSION["palavra"]) {
        if ($con->query($inserir_usuario) === TRUE) {
            $mensagem = "Usuário inserido com sucesso!";
        } else {
            $erros = implode("\n", $erros);
            $mensagem = "Erro ao inserir usuário:\n" . $erros;
        }
        
        header("Location: entrar.php?mensagem=" . urlencode($mensagem)); // Redireciona para index.php com a mensagem
        exit();
    } else {
        $mensagem = "Captcha inválido.";
        header("Location: entrar.php?mensagem=" . urlencode($mensagem)); // Redireciona para index.php com a mensagem
        exit();
    }
}
?>
