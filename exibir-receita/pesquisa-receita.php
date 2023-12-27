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

    include "../entrar/conectar-bd.php";

    session_start();

    if (isset($_GET['id'])) {
        $receitaId = $_GET['id'];

        $sqlReceita = "SELECT * FROM receitas WHERE id = $receitaId";
        $resultReceita = $con->query($sqlReceita);

        if ($resultReceita->num_rows > 0) {
            $rowReceita = $resultReceita->fetch_assoc();

            echo "<div class='resultado'>";

            echo "<div class='data'>";
            echo "<p><b>Data de publicação:</b> {$rowReceita['data']}</p></b>";
            if (isset($rowReceita['data_atualizada']) && $rowReceita['data_atualizada'] != NULL) {
                echo "<p><b>Data da edição:</b> {$rowReceita['data_atualizada']}</p>";
            }
            echo "</div>";
            
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

            if (isset($_SESSION["id"]) && $_SESSION["id"] == $rowReceita['id_usuario']) {
                echo "<button class='btn'style='text-decoration: none;'><a href='editar-receita.php?id={$receitaId}'>Editar</a></button>";
                echo "<button class='btn'style='text-decoration: none;'><a href='excluir-receita.php?id={$receitaId}'>Excluir</a></button>";
            }
            
            echo "</div>";
        } else {
            echo "<p>Receita não encontrada.</p>";
        }
    } else {
        echo "<p>ID de receita não fornecido.</p>";
    }

    $con->close();
    ?>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>

</body>

</html>