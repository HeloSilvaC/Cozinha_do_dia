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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Link para o arquivo de estilo personalizado (CSS) -->
    <link rel="stylesheet" href="entrar.css">
    <!-- Link para o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        <div class="cadastro-container">
            <h2>Cadastre-se</h2>
            <form action="valida-cadastro.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="genero">Gênero:</label>
                <div class="genero-container">
                    <input type="radio" id="genero-masculino" name="genero" value="masculino" required>
                    <label for="genero-masculino">Masculino</label>

                    <input type="radio" id="genero-feminino" name="genero" value="feminino">
                    <label for="genero-feminino">Feminino</label>

                    <input type="radio" id="genero-outro" name="genero" value="outro">
                    <label for="genero-outro">Outro</label>
                </div>

                <label for="email-cadastro">E-mail:</label>
                <input type="email" id="email-cadastro" name="email-cadastro" required>

                <label for="senha-cadastro">Senha:</label>
                <input type="password" id="senha-cadastro" name="senha-cadastro" minlength="6" required>

                <label for="confirma-senha">Confirme a senha:</label>
                <input type="password" id="confirma-senha" name="confirma-senha" minlength="6" required>

                <label for="telefone-cadastro">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" pattern="\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}" required
                    placeholder="(DD) 9XXX-XXXX">

                <div class="checkbox-container">
                    <input type="checkbox" id="concordo" name="concordo" required>
                    <label for="concordo"> Eu concordo com os <a href="termos.php">termos de serviço</a></label>
                </div>

                <div class="captcha-container">
                    <div class="captcha-image-container">
                        <img src="captcha.php" alt="Imagem do Captcha" class="captcha-image" id="captcha-image">
                    </div>
                    <div class="captcha-input-container">
                        <input type="text" name="captcha" class="captcha-input" placeholder="Digite o Captcha" required>
                    </div>
                    <button type="button" id="refresh-captcha">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
                <input type="submit" value="Cadastrar">
            </form>
        </div>

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
        <p>&copy;
            <?php echo date("Y"); ?> Cozinha do dia.
        </p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script>
        window.onload = function () {

            $(document).ready(function () {
                // Função para transformar a primeira letra em maiúscula
                function capitalizeFirstLetter(inputField) {
                    var currentValue = $(inputField).val();
                    currentValue = currentValue.charAt(0).toUpperCase() + currentValue.slice(1);
                    $(inputField).val(currentValue);
                }

                // Função para validar campos obrigatórios
                function validateRequired(inputField) {
                    if ($(inputField).val().trim() === '') {
                        inputField.setCustomValidity('Este campo é obrigatório.');
                    } else {
                        inputField.setCustomValidity('');
                    }
                }

                // Função para validar um endereço de e-mail com uma expressão regular
                function validateEmail(inputField) {
                    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!emailPattern.test($(inputField).val())) {
                        inputField.setCustomValidity('Por favor, insira um endereço de e-mail válido.');
                    } else {
                        inputField.setCustomValidity('');
                    }
                }

                // Aplicar comportamento para todos os campos de texto
                $('input[type="text"]').on('input', function () {
                    capitalizeFirstLetter(this);
                    validateRequired(this);
                });

                // Aplicar comportamento para o campo de email
                $('#email-cadastro').on('input', function () {
                    validateRequired(this);
                    validateEmail(this);
                });

                // Aplicar comportamento para campos de senha
                $('input[type="password"]').on('input', function () {
                    validateRequired(this);
                    if (this.value.length < 6) {
                        this.setCustomValidity('A senha deve conter pelo menos 6 caracteres.');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                // Aplicar comportamento para o campo de confirmação de senha
                $('#confirma-senha').on('input', function () {
                    validateRequired(this);
                    if (this.value !== $('#senha-cadastro').val()) {
                        this.setCustomValidity('As senhas não coincidem. Por favor, confirme a senha novamente.');
                    } else {
                        this.setCustomValidity('');
                    }
                });


                $('#telefone').on('input', function () {
                    var unformatted = $(this).val().replace(/[^\d]/g, '');
                    if (unformatted.length >= 11) {
                        $(this).val('(' + unformatted.substr(0, 2) + ') ' + unformatted.substr(2, 5) + '-' + unformatted.substr(7, 4));
                    } else if (unformatted.length >= 2) {
                        $(this).val('(' + unformatted.substr(0, 2) + ') ' + unformatted.substr(2));
                    } else {
                        $(this).val(unformatted);
                    }
                });

                $('#concordo').on('change', function () {
                    if (!this.checked) {
                        this.setCustomValidity('Você deve concordar com os termos de serviço.');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                // Aplicar comportamento para o campo do Captcha
                $('.captcha-input').on('input', function () {
                    validateRequired(this);
                });

            });

            function refreshCaptcha() {
                // Gere um novo timestamp para forçar o recarregamento da imagem do captcha
                var timestamp = new Date().getTime();
                var captchaImage = document.getElementById('captcha-image');
                captchaImage.src = 'captcha.php?t=' + timestamp; // Adicione o timestamp como parâmetro GET
            }

            // Adicione um ouvinte de evento ao botão "Recarregar Captcha"
            var refreshButton = document.getElementById('refresh-captcha');
            if (refreshButton) {
                refreshButton.addEventListener('click', function () {
                    refreshCaptcha();
                });
            }

            <?php if (isset($_GET['mensagem'])) { ?>
                if ("<?= $_GET['mensagem'] ?>" === "true") {
                    Swal.fire({
                        title: "Usuário cadastrado com sucesso!",
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.getPopup().style.backgroundColor = '#fff';
                            Swal.getPopup().style.fontFamily = 'Roboto Mono';
                            Swal.getPopup().style.fontSize = '15px';
                            Swal.getPopup().style.color = '#DF901A';
                            Swal.getPopup().style.borderColor = '#ccc';
                        },
                        willClose: () => {
                            window.location.href = window.location.pathname;
                            clearInterval(timerInterval);
                        }
                    });
                } else if ("<?= $_GET['mensagem'] ?>" === "false") {
                    Swal.fire({
                        title: "Erro ao cadastrar!",
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.getPopup().style.backgroundColor = '#fff';
                            Swal.getPopup().style.fontFamily = 'Roboto Mono';
                            Swal.getPopup().style.fontSize = '15px';
                            Swal.getPopup().style.color = '#DF901A';
                            Swal.getPopup().style.borderColor = '#ccc';
                        },
                        willClose: () => {
                            window.location.href = window.location.pathname;
                            clearInterval(timerInterval);
                        }
                    });
                } else if ("<?= $_GET['mensagem'] ?>" === "false-captcha") {
                    Swal.fire({
                        title: "Erro no captcha!",
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.getPopup().style.backgroundColor = '#fff';
                            Swal.getPopup().style.fontFamily = 'Roboto Mono';
                            Swal.getPopup().style.fontSize = '15px';
                            Swal.getPopup().style.color = '#DF901A';
                            Swal.getPopup().style.borderColor = '#ccc';
                        },
                        willClose: () => {
                            window.location.href = window.location.pathname;
                            clearInterval(timerInterval);
                        }
                    });
                }


                else if ("<?= $_GET['mensagem'] ?>" === "senha-invalida") {
                    Swal.fire({
                        title: "Senha inválida!",
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.getPopup().style.backgroundColor = '#fff';
                            Swal.getPopup().style.fontFamily = 'Roboto Mono';
                            Swal.getPopup().style.fontSize = '15px';
                            Swal.getPopup().style.color = '#DF901A';
                            Swal.getPopup().style.borderColor = '#ccc';
                        },
                        willClose: () => {
                            window.location.href = window.location.pathname;
                            clearInterval(timerInterval);
                        }
                    });
                }


                else if ("<?= $_GET['mensagem'] ?>" === "email-invalido") {
                    Swal.fire({
                        title: "E-mail inválido!",
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.getPopup().style.backgroundColor = '#fff';
                            Swal.getPopup().style.fontFamily = 'Roboto Mono';
                            Swal.getPopup().style.fontSize = '15px';
                            Swal.getPopup().style.color = '#DF901A';
                            Swal.getPopup().style.borderColor = '#ccc';
                        },
                        willClose: () => {
                            window.location.href = window.location.pathname;
                            clearInterval(timerInterval);
                        }
                    });
                }

            <?php } ?>


        }
    </script>
</body>

</html>