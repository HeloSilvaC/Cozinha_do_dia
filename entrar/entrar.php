<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links para as fontes do Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <!-- Link para o Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Link para o arquivo de estilo personalizado (CSS) -->
    <link rel="stylesheet" href="entrar.css">
    <title>Cadastro - Cozinha do Dia</title>
</head>

<body>
    <!-- Seção do Cabeçalho -->
    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">COZINHA DO DIA</h1>
        </a>
    </header>

    <!-- Seção de Cadastro e Login -->
    <div class="container">
        <!-- Container do Cadastro -->
        <!-- Container do Cadastro -->
        <div class="cadastro-container">
            <h2>Cadastre-se</h2>
            <form action="valida-cadastro.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome"
                    oninput="this.value = this.value.replace(/^\w/, c => c.toUpperCase()); this.setCustomValidity('');"
                    required oninvalid="this.setCustomValidity('Por favor, preencha o nome corretamente.');">

                <label for="email-cadastro">E-mail:</label>
                <input type="email" id="email-cadastro" name="email-cadastro" required required
                    oninvalid="this.setCustomValidity('Por favor, preencha o nome Por favor, insira um e-mail válido.');"
                    oninput="this.setCustomValidity('');">

                <label for="senha-cadastro">Senha:</label>
                <input type="password" id="senha-cadastro" name="senha-cadastro" minlength="6" required
                    oninvalid="this.setCustomValidity('Por favor, insira uma senha com pelo menos 6 caracteres.');"
                    oninput="this.setCustomValidity('');">

                <label for="confirma-senha">Confirme a senha:</label>
                <input type="password" id="confirma-senha" name="confirma-senha" minlength="6" required
                    oninvalid="this.setCustomValidity('As senhas não coincidem. Por favor, confirme a senha novamente.');"
                    oninput="this.setCustomValidity('');">

                <div class="captcha-container">
                    <div class="captcha-image-container">
                        <img src="../captcha.php" alt="Imagem do Captcha" class="captcha-image">
                    </div>
                    <div class="captcha-input-container">
                        <input type="text" name="captcha" class="captcha-input" placeholder="Digite o Captcha" required
                            oninvalid="this.setCustomValidity('Por favor, digite o Captcha');"
                            oninput="this.setCustomValidity('');">
                    </div>
                </div>
                <input type="submit" value="Cadastrar">
            </form>
        </div>

        <p class="or-text">ou</p>

        <!-- Container do Login -->
        <div class="login-container">
            <h2>Login</h2>
            <form action="valida-login.php" method="POST">
                <label for="email-login">E-mail:</label>
                <input type="email" id="email-login" name="email-login" required>
                <label for="senha-login">Senha:</label>
                <input type="password" id="senha-login" name="senha-login" required>
                <input type="submit" value="Entrar">
            </form>
            <div class="social-login">
                <p>ou entre com:</p>
                <div class="social-icons">
                    <a href="#" class="facebook-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="google-icon"><i class="fab fa-google"></i></a>
                </div>
            </div>
        </div>

    </div>
    <!-- Seção do Rodapé -->
    <footer class="footer">
    </footer>


    <script>
        window.onload = function () {
            var j = <?php $obj = json_decode($json_str, true); echo json_encode($obj); ?>;

            if (j.status === "ok") {
                alert("Usuário inserido com sucesso!");
            } else if (j.status === "erro") {
                var erros = <?php echo json_encode($erros); ?>; // Pega os erros do PHP

                if (erros.length > 0) {
                    var errorMessage = "Erro ao inserir usuário:\n";

                    for (var i = 0; i < erros.length; i++) {
                        errorMessage += "- " + erros[i] + "\n";
                    }

                    alert(errorMessage);
                }
            }
        }
    </script>


</body>

</html>