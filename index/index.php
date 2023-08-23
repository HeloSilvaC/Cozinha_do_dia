<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
$estaLogado = isset($_SESSION["estaLogado"]) && $_SESSION["estaLogado"];
$nomeUsuario = isset($_SESSION["nomeUsuario"]) ? $_SESSION["nomeUsuario"] : '';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- Link para o Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Link para o arquivo de estilo personalizado (CSS) -->
    <link rel="stylesheet" href="index.css">
    <title>Cozinha do Dia</title>
</head>

<body>
    <!-- Seção do Cabeçalho -->
    <header class="header">
        <!-- Logo e título do site -->
        <a href="index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">COZINHA DO DIA</h1>
        </a>

        <!-- Caixa de busca -->
        <div class="search-box">
            <input type="search" id="search" name="search" placeholder="Encontre uma receita..."
                onkeydown="searchOnEnter(event)">
            <i class="fas fa-search search-icon" onclick="searchRecipe()"></i>
        </div>

        <!-- Contêiner do perfil com opções de login/cadastro -->
        <div class="perfil-container">
            <!-- Ícone de perfil -->
            <i class="fas fa-user-circle" tabindex="0"></i>
            <!-- Mensagem de boas-vindas -->
            <p class="bem-vindo-msg"></p>
            <!-- Opções do perfil -->
            <div class="opcoes-perfil">
                <ul>
                    <!-- Opção para entrar -->
                    <li><a href="../entrar/entrar.php">Entrar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Seção de Receitas -->
    <div id="receitas">
        <!-- Cards de receitas -->
        <a href="pagina_da_receita1.html" class="card">
            <img src="../Imagens/Panqueca.png" alt="Panqueca">
            <div class="card-text">
                <h1>PANQUECA AMERICANA</h1>
            </div>
        </a>
        <a href="pagina_da_receita2.html" class="card">
            <img src="../Imagens/ovo_frito.png" alt="Ovo frito">
            <div class="card-text">
                <h1>OVO FRITO</h1>
            </div>
        </a>
        <a href="pagina_da_receita4.html" class="card">
            <img src="../Imagens/guacamole.png" alt="Guacamole">
            <div class="card-text">
                <h1>GUACAMOLE</h1>
            </div>
        </a>
        <a href="pagina_da_receita3.html" class="card">
            <img src="../Imagens/salada_de_frutas.png" alt="Salada de frutas">
            <div class="card-text">
                <h1>SALADA DE FRUTAS</h1>
            </div>
        </a>
    </div>

    <!-- Seção do Rodapé -->
    <footer class="footer">
    </footer>

    <!-- Script JavaScript -->
    <script>

        // Função para pesquisar quando a tecla "Enter" for pressionada
        function searchOnEnter(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Evita a ação padrão do formulário
                searchRecipe();
            }
        }

        // Função para realizar a pesquisa
        function searchRecipe() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            window.location.href = `../receita.php?search=${encodeURIComponent(searchTerm)}`;
        }

        // Redireciona para receitas.html com o termo de pesquisa na URL
        document.addEventListener('DOMContentLoaded', function () {
            // Obtém o contêiner do perfil
            const perfilContainer = document.querySelector('.perfil-container');
            // Verifica se o usuário está logado
            const estaLogado = <?php echo $estaLogado ? 'true' : 'false'; ?>;
            const nomeUsuario = "<?php echo $nomeUsuario; ?>";
            // Obtém as opções do perfil
            const opcoesPerfil = perfilContainer.querySelector('.opcoes-perfil ul');

            if (estaLogado) {
                // Estiliza o ícone de perfil
                perfilContainer.style.cursor = 'pointer';
                const iconUser = perfilContainer.querySelector('.fas.fa-user-circle');
                iconUser.style.fontSize = '35px'; // Tamanho do ícone
                iconUser.style.color = '#fff';
                iconUser.style.transition = 'box-shadow 0.2s ease-in-out, transform 0.3s ease-in-out';
                iconUser.style.borderRadius = '10%';
                // Cria mensagem de boas-vindas
                const bemVindoMsg = document.createElement('p');
                bemVindoMsg.textContent = `Bem-vindo,${nomeUsuario}!`;
                bemVindoMsg.style.fontFamily = 'Roboto Mono, monospace';
                bemVindoMsg.style.fontWeight = 'bold';
                bemVindoMsg.style.fontSize = '15px';
                bemVindoMsg.style.textAlign = 'center';
                bemVindoMsg.style.marginLeft = '5px';
                bemVindoMsg.style.color = '#fff';
                perfilContainer.appendChild(bemVindoMsg);

                // Atualiza as opções do perfil para usuário logado
                opcoesPerfil.innerHTML = `
                    <li><a href="../cadastro-receitas/cadastro-receita.php">Cadastrar Receita</a></li>
                    <li><a href="logout.php">Sair</a></li>
                `;
            } else {
                // Atualiza as opções do perfil para usuário não logado
                opcoesPerfil.innerHTML = `
                    <li><a href="../entrar/entrar.php">Entrar</a></li>
                `;
            }
        });
    </script>
</body>

</html>