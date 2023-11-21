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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Cadastro de Receitas - Cozinha do Dia</title>
</head>

<style>
    .thumbnail {
        width: 100px;
        height: 100px;
        object-fit: cover;
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

    <form method="POST" action="processar-receita.php" enctype="multipart/form-data" class="container-cadastro">
        <!-- Campo das imagens da receita -->
        <div class="container-cadastro-esquerda">
            <label for="imagens-receita">
                <p class="legend">Imagens da Receita:</p>
            </label>
            <input type="file" id="imagens-receita" name="uploadfile" multiple="multiple">
            <div id="visualizacao"></div>
        </div>
        <div class="container-cadastro-direita">
            <!-- Campo do nome da receita -->
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

            <!-- Botão de submit -->
            <button type="submit" id="btn-cadastrar">Cadastrar receita</button>
        </div>
    </form>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>

    <script src="cadastro-receita.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <script>
        <?php if (isset($_GET['mensagem'])) { ?>
            if ("<?= $_GET['mensagem'] ?>" == "true") {
                Swal.fire({
                    title: "Receita cadastrada com sucesso!",
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
                        window.location.href = '../index/index.php';
                    }
                });
            } else if ("<?= $_GET['mensagem'] ?>" == "false") {
                Swal.fire({
                    title: "Erro ao cadastrar a receita!",
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
                        window.location.href = '../index/index.php';
                    }
                });
            }
        <?php } ?>
    </script>

</body>

</html>