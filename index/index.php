<?
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION["estaLogado"]) || $_SESSION["estaLogado"] !== true) {
    header("Location: ../entrar/entrar.php");
    exit();
}
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
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <!-- Link para o Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Link para o arquivo de estilo personalizado (CSS) -->
    <link rel="stylesheet" href="index.css">
    <title>Cozinha do Dia</title>
</head>

<body>
    <!-- Seção do Cabeçalho -->
    <header class="header">
        <a href="index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">COZINHA DO DIA</h1>
        </a>
        <div class="search-box">
            <input type="search" id="search" name="search" placeholder="Encontre uma receita...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <!-- Contêiner do perfil com opções de login/cadastro -->
        <div class="perfil-container">
            <i class="fas fa-user-circle" tabindex="0"></i>
            <div class="opcoes-perfil">
                <ul>
                    <li><a href="../entrar/entrar.php">Entrar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Seção de Receitas -->
    <div id="receitas">
        <!-- Cada card é um link para a página da receita -->
        <a href="pagina_da_receita1.html" class="card">
            <img src="/Imagens/Panqueca.png" alt="Panqueca">
            <div class="card-text">
                <h1>PANQUECA AMERICANA</h1>
            </div>
        </a>
        <a href="pagina_da_receita2.html" class="card">
            <img src="/Imagens/ovo_frito.png" alt="Ovo frito">
            <div class="card-text">
                <h1>OVO FRITO</h1>
            </div>
        </a>
        <a href="pagina_da_receita4.html" class="card">
            <img src="/Imagens/guacamole.png" alt="Guacamole">
            <div class="card-text">
                <h1>GUACAMOLE</h1>
            </div>
        </a>
        <a href="pagina_da_receita3.html" class="card">
            <img src="/Imagens/salada_de_frutas.png" alt="Salada de frutas">
            <div class="card-text">
                <h1>SALADA DE FRUTAS</h1>
            </div>
        </a>
    </div>

    <!-- Seção do Rodapé -->
    <footer class="footer">
    </footer>
</body>

</html>