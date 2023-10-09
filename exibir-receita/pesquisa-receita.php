<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "cozinha_do_dia";

$con = new mysqli($host, $usuario, $senha, $banco);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cozinha do Dia</title>
    <link rel="stylesheet" type="text/css" href="pesquisa-receita.css">
</head>

<body>

    <!-- Seção do Cabeçalho -->
    <header class="header">
        <a href="../index/index.php" style="text-decoration: none;">
            <h1 data-text="COZINHA DO DIA">CADASTRO DE RECEITAS</h1>
        </a>
    </header>
    <?php
    if (isset($_GET['search'])) {
        $termoPesquisa = $_GET['search'];

        // Consulta SQL para buscar receitas com base no termo de pesquisa
        $sqlPesquisa = "SELECT * FROM receitas WHERE nome LIKE '%$termoPesquisa%'";
        $resultPesquisa = $con->query($sqlPesquisa);

        // Verifique se a pesquisa retornou resultados
        if ($resultPesquisa->num_rows > 0) {
            echo "<div class='resultados-pesquisa'>";

            while ($rowReceita = $resultPesquisa->fetch_assoc()) {
                // Exiba as informações da receita dentro do loop
                echo "<div class='resultado'>";
                echo "<h3>{$rowReceita['nome']}</h3>";
                echo "<p>Tempo de Preparo: {$rowReceita['tempo_preparo']} minutos</p>";
                echo "<p>Porções: {$rowReceita['porcoes']}</p>";
                echo "<p>Categoria: {$rowReceita['categoria']}</p>";

                // Consulta SQL para obter ingredientes da receita
                $sqlIngredientes = "SELECT * FROM ingredientes WHERE receita_id = {$rowReceita['id']}";
                $resultIngredientes = $con->query($sqlIngredientes);

                echo "<h3>Ingredientes:</h3>";
                echo "<ul class='lista-ingredientes'>";
                while ($rowIngrediente = $resultIngredientes->fetch_assoc()) {
                    echo "<li>{$rowIngrediente['nome']} - {$rowIngrediente['quantidade']} {$rowIngrediente['unidade']}</li>";
                }
                echo "</ul>";

                // Consulta SQL para obter o modo de preparo da receita
                $sqlModoPreparo = "SELECT * FROM modo_preparo WHERE receita_id = {$rowReceita['id']} ORDER BY ordem";
                $resultModoPreparo = $con->query($sqlModoPreparo);

                echo "<h3>Modo de Preparo:</h3>";
                echo "<ol class='lista-passos'>";
                while ($rowPasso = $resultModoPreparo->fetch_assoc()) {
                    echo "<li>{$rowPasso['passo']}</li>";
                }
                echo "</ol>";

                echo "</div>"; // Feche a div 'resultado'
            }

            echo "</div>"; // Feche a div 'resultados-pesquisa'
        } else {
            echo "<p>Nenhum resultado encontrado para \"$termoPesquisa\".</p>";
        }
    }

    // Feche a conexão com o banco de dados
    $con->close();
    ?>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Cozinha do dia.</p>
    </footer>

</body>

</html>
