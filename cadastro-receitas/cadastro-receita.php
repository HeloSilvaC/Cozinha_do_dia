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
   
    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">CADASTRO DE RECEITAS</h1>
        </a>
    </header>

    <form method="POST" action="processar-receita.php" enctype='multipart/form-data' class="container-cadastro">

        <div class="container-cadastro-esquerda">

            <p class="receita">Nome da Receita:</p>
            <input type="text" id="nome-receita" name="nome-receita" required class="input-text">

            <p class="ingredientes">Ingredientes</p>

            <div id="organizar">
                <div class="ingrediente">

                    <input type="text" id="nome-ingrediente" name="ingredientes[]" placeholder="Nome do ingrediente" required>

                    <input type="number" id="quantidade-ingrediente" name="quantidades[]" class="label-ingrediente" placeholder="Quantidade" required min="0">

                    <select name="unidades[]" class="label-ingrediente" required>
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
            </br>

            <label for="imagens-receita">
                <p class="img-receitas">Imagens da Receita:</p>
            </label>
            <input type="file" id="imagens-receita" name="uploadfile">
            <div id="visualizacao"></div>
        </div>


        <div class="container-cadastro-direita">

            <p class="modoPreparo">Modo de Preparo</p>
            <ol id="modo-preparo-lista">
                <li>
                    <textarea name="modo-preparo[]" placeholder="Passo 1" rows="3" required></textarea>
                    <button type="button" class="btn-remover">
                        <i class="fa fa-trash"></i>
                    </button>
                </li>
            </ol>
            <button type="button" id="btn-adicionar-passo">Adicionar Novo Passo</button>
            </br>

            <div class="tempo-porcoes-container">
                <div class="tempo-preparo">
                    <p class="tempoPreparo">Tempo de Preparo (min):</p>
                    <input type="number" id="tempo-preparo" name="tempo-preparo" required class="input-number" min="0">
                </div>
            </div>
            
                <div class="porcoes">
                    <p class="porcoes">Porções:</p>
                    <input type="number" id="porcoes" name="porcoes" required class="input-number" min="0">
                </div>
                
                <div class="categoria">
                    <p class="categoria">Categoria:</p>
                    <select id="categoria" name="categoria" required>
                        <option value="massas">Massas</option>
                        <option value="carnes">Carnes</option>
                        <option value="vegetariana">Vegetariana</option>
                        <option value="sobremesas">Sobremesas</option>
                    </select>
                </div>

            
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