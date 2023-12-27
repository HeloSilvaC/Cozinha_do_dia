    <?php
    session_start();

    $session_timeout = 1800; // 30 minutos


    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }


    $_SESSION['LAST_ACTIVITY'] = time();


    $estaLogado = isset($_SESSION["estaLogado"]) && $_SESSION["estaLogado"];
    $nomeUsuario = isset($_SESSION["nomeUsuario"]) ? $_SESSION["nomeUsuario"] : '';
    ?>



    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


        <link rel="stylesheet" href="../index/index.css">

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
            <form method="GET" action="../exibir-receita/lista-receitas.php">
                <div class="search-box">
                    <input type="search" id="search" name="search" placeholder="Encontre uma receita...">
                    <button type="submit" class="search-icon"><i class="fas fa-search"></i></button>
                </div>
            </form>


            <div class="perfil-container">
                <!-- Ícone de perfil -->
                <i class="fas fa-user-circle" tabindex="0"></i>
                <!-- Mensagem de boas-vindas -->
                <p class="bem-vindo-msg"></p>
                <!-- Opções do perfil -->
                <div class="opcoes-perfil">
                    <ul>
                        <li><a href="../entrar/entrar.php">Entrar</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="receitas-images">
            <?php
            // Conecta ao servidor MySQL
            include "../entrar/conectar-bd.php";

            // Consulta para obter as últimas 4 receitas com imagens
            $sqlImagens = "SELECT r.id, r.nome, i.filename FROM receitas r
            INNER JOIN image i ON r.id = i.receita_id
            ORDER BY r.id DESC LIMIT 4";
            $resultImagens = $con->query($sqlImagens);

            if ($resultImagens->num_rows > 0) {
                while ($rowImagem = $resultImagens->fetch_assoc()) {
                    echo '<div class="receita-image">';
                    echo '<a href="../exibir-receita/pesquisa-receita.php?id=' . $rowImagem["id"] . '">';
                    echo '<img src="../imagem/' . $rowImagem["filename"] . '" alt="' . $rowImagem["nome"] . '">';
                    echo '<p>' . $rowImagem["nome"] . '</p>';
                    echo '</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <footer class="footer">
            <p>&copy;
                <?php echo date("Y"); ?> Cozinha do dia.
            </p>
        </footer>

        <script>
            // Redireciona para receitas.html com o termo de pesquisa na URL
            document.addEventListener('DOMContentLoaded', function() {
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
                    bemVindoMsg.textContent = `Bem-vindo, ${nomeUsuario}!`;
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