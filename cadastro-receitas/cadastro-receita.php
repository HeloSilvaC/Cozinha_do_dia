<?php
//session_start();

// Verifica se o usuário está logado
//$estaLogado = isset($_SESSION["estaLogado"]) && $_SESSION["estaLogado"];

// Redireciona para a página de login se o usuário não estiver logado
//if (!$estaLogado) {
//  header("Location: ../index.php");
//  exit();
//}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="cadastro-receita.css">
    <title>Cadastro de Receitas - Cozinha do Dia</title>
</head>

<body>
    <!-- Seção do Cabeçalho -->
    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">COZINHA DO DIA</h1>
        </a>
    </header>

    <!-- Seção do Cadastro de Receitas -->
    <div class="container-geral">
        <!-- Container do Cadastro de Receitas -->
        <div class="cadastro-container">
            <h2>Cadastro de Receitas</h2>
            </br>
            <form method="POST" action="processar-receita.php" enctype="multipart/form-data">
                <!-- Campo do nome da receita -->
                <label for="nome-receita"><b>Nome da Receita:</b></label>
                <input type="text" id="nome-receita" name="nome-receita" required class="input-text">
                </br>
                <!-- Grupo de campos dos ingredientes -->
                <fieldset>
                    <legend>Ingredientes</legend>
                    <div class="ingredientes-container">
                        <div class="ingrediente">
                            <!-- Campo do nome do ingrediente -->
                            <input type="text" id="nome-ingrediente" name="ingredientes[]"
                                placeholder="Nome do ingrediente" required>

                            <!-- Campo da quantidade do ingrediente -->
                            <input type="number" name="quantidades[]" placeholder="Quantidade" required min="0">

                            <!-- Campo da unidade de medida -->
                            <select name="unidades[]" required>
                                <option value="" disabled selected>Escolher unidade</option>
                                <option value="g">grama(s)</option>
                                <option value="kg">quilograma(s)</option>
                                <option value="ml">mililitro(s)</option>
                                <option value="l">litro(s)</option>
                                <option value="un">unidade(s)</option>
                            </select>

                            <button type="button" class="btn-remover">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="btn-adicionar-ingrediente">Adicionar Novo Ingrediente</button>
                </fieldset>
                </br>

                <!-- Grupo de campos do modo de preparo -->

                <fieldset>
                    <legend>Modo de Preparo</legend>
                    <ol id="modo-preparo-lista">
                        <!-- Incluí apenas um passo inicial -->
                        <li>
                            <textarea name="modo-preparo[]" placeholder="Passo 1" rows="3" required></textarea>
                            <button type="button" class="btn-remover">
                                <i class="fa fa-trash"></i>
                            </button>
                        </li>
                    </ol>
                    <button type="button" id="btn-adicionar-passo">Adicionar Novo Passo</button>
                </fieldset>
                </br>
        </div>
        <div class="container-direita">
            <!-- Campo do tempo de preparo e das porções -->
            <div class="tempo-porcoes-container">
                <div class="tempo-preparo">
                    <label for="tempo-preparo"><b>Tempo de Preparo (min):</b></label>
                    <input type="number" id="tempo-preparo" name="tempo-preparo" required class="input-number" min="0">
                </div>

                <div class="porcoes">
                    <label for="porcoes"><b>Porções:</b></label>
                    <input type="number" id="porcoes" name="porcoes" required class="input-number" min="0">
                </div>
            </div>
            </br>

            <!-- Campo da categoria -->
            <label for="categoria"><b>Categoria:</b></label>
            <select id="categoria" name="categoria" required>
                <option value="massas">Massas</option>
                <option value="carnes">Carnes</option>
                <option value="vegetariana">Vegetariana</option>
                <option value="sobremesas">Sobremesas</option>
                <!-- Adicione mais opções conforme necessário -->
            </select>
            </br>
            <!-- Imagens da receita -->
            <!-- No seu HTML, adicione uma div para a visualização das imagens -->
            <div class="imagens-container">
                <label for="imagens-receita"><b>Imagens da Receita:</b></label>
                <input type="file" id="imagem-receita" name="imagens-receita[]" accept="image/*" multiple>
                <div class="imagem-preview-container"></div>
            </div>
            </br>
            <input type="submit" id="btn-cadastrar" value="Cadastrar Receita">
        </div>


        </form>
    </div>


    <footer class="footer">
        <p>&copy;
            <?php echo date("Y"); ?> Cozinha do dia.
        </p>
    </footer>

    <script src="cadastro-receita.js"></script>
</body>

</html>