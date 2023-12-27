<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cozinha do Dia</title>
    <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="editar-receita.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            <h1 data-text="COZINHA DO DIA">EDIÇÃO DE RECEITAS</h1>
        </a>
    </header>

    <?php
   
    include "../entrar/conectar-bd.php";

    if (isset($_GET['id'])) {
        $receitaId = $_GET['id'];

        $sqlReceita = "SELECT * FROM receitas WHERE id = $receitaId";
        $resultReceita = $con->query($sqlReceita);

        $sqlImagem = "SELECT filename FROM image WHERE receita_id = $receitaId";
        $resultImagem = $con->query($sqlImagem);

        $sqlIngredientes = "SELECT * FROM ingredientes WHERE receita_id = $receitaId";
        $resultIngredientes = $con->query($sqlIngredientes);

        $sqlModoPreparo = "SELECT * FROM modo_preparo WHERE receita_id = $receitaId ORDER BY ordem";
        $resultModoPreparo = $con->query($sqlModoPreparo);

        $rowReceita = $resultReceita->fetch_assoc();
    } else {
        echo "<p>ID de receita não fornecido.</p>";
        exit();
    }

    $con->close();

    ?>

    <form method="post" action="atualizar-receita.php" class="container-cadastro">
        <input name="id" value="<?= $receitaId; ?>" hidden />

        <div class="container-editar-esquerda">

            <p class="receita">Nome da Receita:</p>
            <input type="text" name="nome-receita" id="nome-receita" value="<?= $rowReceita['nome']; ?>">

            <p class="ingredientes">Ingredientes</p>

            <div id="organizar">

                <?php while ($rowIngrediente = $resultIngredientes->fetch_assoc()) : ?>
                    <div class="ingrediente">
                        <input type="hidden" name="id-ingrediente[]" value="<?= $rowIngrediente['id']; ?>">

                        <input type="text" name="nome-ingrediente[]" id="nome-ingrediente" value="<?= $rowIngrediente['nome']; ?>">

                        <input type="number" id="quantidade-ingrediente" name="quantidade-ingrediente[]" class="label-ingrediente" value="<?= $rowIngrediente['quantidade']; ?>">

                        <select name="unidade-ingrediente[]" class="label-ingrediente" value="<?= $rowIngrediente['unidade']; ?>">
                            <option value="g">grama(s)</option>
                            <option value="kg">quilograma(s)</option>
                            <option value="ml">mililitro(s)</option>
                            <option value="l">litro(s)</option>
                            <option value="un">unidade(s)</option>
                        </select>

                        <!-- 
                        <button type="button" class="btn-remover">
                            <i class="fa fa-trash"></i>
                        </button>
                         -->
                    </div>
                <?php endwhile; ?>

            </div>

            <!--<button type="button" id="btn-adicionar-ingrediente">Adicionar Novo Ingrediente</button> !-->
            </br>

            <label for="imagens-receita">
                <p class="img-receitas">Imagens da Receita:</p>
            </label>

            <input type="file" id="imagem-receita" name="uploadfile">

            <div class='visualizacao'>
                <?php
                $sqlImagem = "SELECT filename FROM image WHERE receita_id = $receitaId";

                if ($resultImagem->num_rows > 0) {
                    $rowImagem = $resultImagem->fetch_assoc();
                    $imagemPath = "../imagem/" . $rowImagem['filename'];
                    echo "<div class='image-container'>";
                    echo "<img class='thumbnail' src='$imagemPath' alt='Imagem da Receita'>";
                    echo "</div>";
                }
                ?>
            </div>

        </div>


        <div class="container-editar-direita">

            <p class="modoPreparo">Modo de Preparo:</p>
            <?php while ($rowPasso = $resultModoPreparo->fetch_assoc()) : ?>
                <ol id="modo-preparo-lista">
                    <input type="hidden" name="id-passo-modo-preparo[]" value="<?= $rowPasso['id']; ?>">
                    <li>
                        <textarea name="modo-preparo[]"><?= $rowPasso['passo']; ?></textarea>
                        <!--  
                        <button type="button" class="btn-remover">
                            <i class="fa fa-trash"></i>
                        </button>
                        -->
                    </li>
                </ol>
                <!-- <button type="button" id="btn-adicionar-passo">Adicionar Novo Passo</button> -->
            <?php endwhile; ?>
            </br>

            <div class="tempo-porcoes-container">
                <div class="tempo-preparo">
                    <p class="tempoPreparo">Tempo de Preparo (min):</p>
                    <input type="number" id="tempo-preparo" name="tempo-preparo" class="input-number" value="<?= $rowReceita['tempo_preparo']; ?>">
                </div>
            </div>

            <div class="porcoes">
                <p class="porcoes">Porções:</p>
                <input type="number" name="porcoes" class="input-number" value="<?= $rowReceita['porcoes']; ?>">
            </div>

            <div class="categoria">
                <p class="categoria">Categoria:</p>
                <select name="categoria">
                    <option value="massas" <?php if ($rowReceita['categoria'] == 'massas') echo 'selected'; ?>>Massas</option>
                    <option value="carnes" <?php if ($rowReceita['categoria'] == 'carnes') echo 'selected'; ?>>Carnes</option>
                    <option value="vegetariana" <?php if ($rowReceita['categoria'] == 'vegetariana') echo 'selected'; ?>>Vegetariana</option>
                    <option value="sobremesas" <?php if ($rowReceita['categoria'] == 'sobremesas') echo 'selected'; ?>>Sobremesas</option>
                </select>

            </div>
            <input type="submit" id="btn-cadastrar" value="Atualizar Receita">
        </div>
    </form>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>
</body>

<script src="cadastro-receita.js"></script>

</html>