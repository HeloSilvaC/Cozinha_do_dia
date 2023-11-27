<?php
include "../entrar/conectar-bd.php";


if (isset($_POST['nome'], $_POST['email-cadastro'], $_POST['senha-cadastro'], $_POST['confirma-senha'], $_POST['captcha'])) {
    $nome = $_POST['nome'];
    $email_cadastro = $_POST['email-cadastro'];
    $senha_cadastro = $_POST['senha-cadastro'];
    $confirma_senha = $_POST['confirma-senha'];
    $captcha = $_POST['captcha'];
}

$verificar_email = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
$verificar_email->bind_param("s", $email_cadastro);
$verificar_email->execute();
$resultado_email = $verificar_email->get_result();

$senha_hash = password_hash($senha_cadastro, PASSWORD_BCRYPT);

$inserir_usuario = $con->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$inserir_usuario->bind_param("sss", $nome, $email_cadastro, $senha_hash);

session_start();

if ($_POST["captcha"] == $_SESSION["palavra"]) {
    if ($inserir_usuario->execute()) {
        $mensagem = "true"; // Altere para uma string
        header("Location: entrar.php?mensagem=" . urlencode($mensagem));
        exit();
    } else {
        $mensagem = "false"; // Altere para uma string
        header("Location: entrar.php?mensagem=" . urlencode($mensagem));
        exit();
    }
}

else{
    $mensagem = "false-captcha"; // Altere para uma string
    header("Location: entrar.php?mensagem=" . urlencode($mensagem));
    exit();
}
?>