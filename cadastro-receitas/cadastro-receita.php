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

<style>
    .thumbnail {
        max-width: 100px;
        max-height: 100px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    #visualizacao {
        display: flex;
        flex-wrap: wrap;
    }
</style>

<body>
    <!-- Seção do Cabeçalho -->
    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">CADASTRO DE RECEITAS</h1>
        </a>
    </header>

    <!-- Seção do Cadastro de Receitas -->
    <div class="container-cadastro">
        <form method="POST" action="processar-receita.php" enctype="multipart/form-data">
            <!-- Campo do nome da receita -->
            <fieldset class="ingredientes">
                <p class="legend">Nome da Receita:</p>
                <input type="text" id="nome-receita" name="nome-receita" required class="input-text">

                <!-- Grupo de campos dos ingredientes -->
                <p class="legend">Ingredientes</p>
                <div class="ingredientes-container">
                    <div class="ingrediente">
                        <!-- Campo do nome do ingrediente -->
                        <input type="text" id="nome-ingrediente" name="ingredientes[]" placeholder="Nome do ingrediente" required>

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

                <!-- Grupo de campos do modo de preparo -->
                <p class="legend">Modo de Preparo</p>
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

                <!-- Campo do tempo de preparo e das porções -->
                <div class="tempo-porcoes-container">
                    <div class="tempo-preparo">
                        <p class="legend">Tempo de Preparo (min):</p>
                        <input type="number" id="tempo-preparo" name="tempo-preparo" required class="input-number" min="0">
                    </div>

                    <div class="porcoes">
                        <p class="legend">Porções:</p>
                        <input type="number" id="porcoes" name="porcoes" required class="input-number" min="0">
                    </div>
                </div>

                <!-- Campo da categoria -->
                <p class="legend">Categoria:</p>
                <select id="categoria" name="categoria" required>
                    <option value="massas">Massas</option>
                    <option value="carnes">Carnes</option>
                    <option value="vegetariana">Vegetariana</option>
                    <option value="sobremesas">Sobremesas</option>
                </select>

                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Campo das imagens da receita -->
                    <label for="imagens-receita"><b>Imagens da Receita:</b></label>
                    <input type="file" id="imagens-receita" name="uploadfile" multiple="multiple">
                    <div id="visualizacao"></div>
                </form>

                <!-- Botão de submit -->
                <input type="submit" id="btn-cadastrar" value="Cadastrar Receita">
            </fieldset>
        </form>

    </div>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>

    <script src="cadastro-receita.js"></script>
    <script>
        document.getElementById('imagens-receita').addEventListener('change', function(event) {
            var visualizacao = document.getElementById('visualizacao');

            for (var i = 0; i < event.target.files.length; i++) {
                var file = event.target.files[i];
                var imageType = /image.*/;

                if (!file.type.match(imageType)) {
                    continue;
                }

                var img = document.createElement('img');
                img.classList.add('thumbnail');
                img.file = file;
                visualizacao.appendChild(img);

                var reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img);

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>