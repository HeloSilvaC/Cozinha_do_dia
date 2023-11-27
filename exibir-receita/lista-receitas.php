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
    <title>Cozinha do Dia - Lista de Receitas</title>
    <link rel="stylesheet" type="text/css" href="lista-receitas.css">
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
            echo "<h2>Resultados para \"$termoPesquisa\":</h2>";
            echo "<ul>";

            while ($rowReceita = $resultPesquisa->fetch_assoc()) {
                echo "<li><a href='pesquisa-receita.php?id={$rowReceita['id']}'>{$rowReceita['nome']}</a></li>";
            }

            echo "</ul>";
            echo "</div>";
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