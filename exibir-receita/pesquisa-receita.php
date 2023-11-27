<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cozinha do Dia</title>
    <link rel="stylesheet" type="text/css" href="pesquisa-receita.css">
</head>

<body>

    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">CADASTRO DE RECEITAS</h1>
        </a>
    </header>

    <?php
    // Inclua o arquivo de conexão com o banco de dados
    include "../entrar/conectar-bd.php";

    // Verifica se um ID de receita foi fornecido na URL
    if (isset($_GET['id'])) {
        $receitaId = $_GET['id'];

        // Consulta SQL para obter os detalhes da receita
        $sqlReceita = "SELECT * FROM receitas WHERE id = $receitaId";
        $resultReceita = $con->query($sqlReceita);

        // Verifica se a consulta retornou resultados
        if ($resultReceita->num_rows > 0) {
            $rowReceita = $resultReceita->fetch_assoc();

            echo "<div class='resultado'>";

            // Consulta SQL para obter a imagem da receita
            $sqlImagem = "SELECT filename FROM image WHERE receita_id = $receitaId";
            $resultImagem = $con->query($sqlImagem);

            if ($resultImagem->num_rows > 0) {
                $rowImagem = $resultImagem->fetch_assoc();
                $imagemPath = "../imagem/" . $rowImagem['filename'];
                echo "<img src='$imagemPath' alt='Imagem da Receita'>";
            }

            echo "<div class='principal'>";
            echo "<h2>{$rowReceita['nome']}</h2>";
            echo "<p><b>Tempo de Preparo:</b> {$rowReceita['tempo_preparo']} minutos</p>";
            echo "<p><b>Porções:</b> {$rowReceita['porcoes']}</p>";
            echo "<p><b>Categoria:</b> {$rowReceita['categoria']}</p>";
            echo "</div>";

            // Consulta SQL para obter ingredientes da receita
            $sqlIngredientes = "SELECT * FROM ingredientes WHERE receita_id = $receitaId";
            $resultIngredientes = $con->query($sqlIngredientes);

            echo "<div class='ingredientes-receita'>";
            echo "<h3>Ingredientes:</h3>";
            echo "<ul>";
            while ($rowIngrediente = $resultIngredientes->fetch_assoc()) {
                echo "<li>{$rowIngrediente['nome']} - {$rowIngrediente['quantidade']} {$rowIngrediente['unidade']}</li>";
            }
            echo "</ul>";
            echo "</div>";

            // Consulta SQL para obter o modo de preparo da receita
            $sqlModoPreparo = "SELECT * FROM modo_preparo WHERE receita_id = $receitaId ORDER BY ordem";
            $resultModoPreparo = $con->query($sqlModoPreparo);

            echo "<div class='modo-preparo'>";
            echo "<h3>Modo de Preparo:</h3>";
            echo "<ol>";
            while ($rowPasso = $resultModoPreparo->fetch_assoc()) {
                echo "<li>{$rowPasso['passo']}</li>";
            }
            echo "</ol>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<p>Receita não encontrada.</p>";
        }
    } else {
        echo "<p>ID de receita não fornecido.</p>";
    }

    // Feche a conexão com o banco de dados
    $con->close();
    ?>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>

</body>

</html>