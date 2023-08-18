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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
    <div class="container">
        <!-- Container do Cadastro de Receitas -->
        <div class="cadastro-container">
            <h2>Cadastro de Receitas</h2>
            <form>
                <!-- Campo do nome da receita -->
                <label for="nome-receita">Nome da Receita:</label>
                <input type="text" id="nome-receita" name="nome-receita" required>

                <!-- Campos dos ingredientes -->
                <label for="ingredientes">Ingredientes:</label>
                <div class="ingredientes-container">
                    <div class="ingrediente">
                        <input type="text" id="nome-ingrediente" name="nome-ingrediente"
                            placeholder="Nome do ingrediente" required>
                        <input type="number" id="quantidade-ingrediente" name="quantidade-ingrediente"
                            placeholder="Quantidade" required>
                        <select id="unidade-medida" name="unidade-medida" required>
                            <option value="" disabled selected>Escolher unidade</option>
                        </select>
                        <button type="button" class="btn-remover" onclick="removerIngrediente(this)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <button type="button" id="btn-adicionar-ingrediente">Adicionar Ingrediente</button>

                <!-- Campo do modo de preparo -->
                <label for="modo-preparo">Modo de Preparo:</label>
                <ol id="modo-preparo-lista">
                    <li>
                        <textarea name="modo-preparo-passo" placeholder="Passo 1" rows="3" required></textarea>
                        <button type="button" class="btn-remover" onclick="removerPasso(this)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </li>
                </ol>
                <button type="button" id="btn-adicionar-passo">Adicionar Passo</button>


                <!-- Outros campos do formulário (opcional) -->

                <input type="submit" value="Cadastrar Receita">
            </form>
        </div>
    </div>

    <!-- Seção do Rodapé -->
    <footer class="footer">
        <!-- Conteúdo do rodapé (se houver) -->
    </footer>

</body>

</html>