<?php
// Inclua o arquivo de conexão com o banco de dados
include "../entrar/conectar-bd.php";

// Verifica se o formulário foi submetido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário e aplica filtragem
    $nomeReceita = filter_input(INPUT_POST, "nome-receita", FILTER_SANITIZE_STRING);
    $ingredientes = $_POST["ingredientes"];
    $quantidades = $_POST["quantidades"];
    $unidades = $_POST["unidades"];
    $modoPreparo = $_POST["modo-preparo"];
    $tempoPreparo = $_POST["tempo-preparo"];
    $porcoes = $_POST["porcoes"];
    $categoria = $_POST["categoria"];

    // Prepara a consulta SQL para inserir a receita usando uma consulta preparada
    $sql = "INSERT INTO receitas (nome, tempo_preparo, porcoes, categoria) VALUES (?, ?, ?, ?)";
    $stmtReceita = $con->prepare($sql);
    $stmtReceita->bind_param("ssis", $nomeReceita, $tempoPreparo, $porcoes, $categoria);
    $resultReceita = $stmtReceita->execute();

    // Verifica se a inserção da receita foi bem-sucedida
    if ($resultReceita) {
        // Obtém o ID da receita recém-inserida
        $receitaId = $stmtReceita->insert_id;

        // Loop para inserir ingredientes usando uma consulta preparada
        for ($i = 0; $i < count($ingredientes); $i++) {
            $sql = "INSERT INTO ingredientes (receita_id, nome, quantidade, unidade) VALUES (?, ?, ?, ?)";
            $stmtIngredientes = $con->prepare($sql);
            $stmtIngredientes->bind_param("issi", $receitaId, $ingredientes[$i], $quantidades[$i], $unidades[$i]);
            $resultIngredientes = $stmtIngredientes->execute();
            $stmtIngredientes->close(); // Feche a consulta preparada

            if (!$resultIngredientes) {
                // Exibe uma mensagem de erro em caso de falha na inserção de ingredientes
                $erro = "Ocorreu um erro durante a inserção dos ingredientes.";
                break; // Saia do loop em caso de erro
            }
        }

        // Verifica se a inserção de ingredientes foi bem-sucedida
        if (empty($erro)) {
            // Loop para inserir modo de preparo na ordem correta
            for ($ordem = 0; $ordem < count($modoPreparo); $ordem++) {
                $passo = $modoPreparo[$ordem];
                $ordemMaisUm = $ordem + 1;
                $sql = "INSERT INTO modo_preparo (receita_id, passo, ordem) VALUES (?, ?, ?)";
                $stmtPasso = $con->prepare($sql);
                $stmtPasso->bind_param("isi", $receitaId, $passo, $ordemMaisUm);
                $resultPasso = $stmtPasso->execute();
                $stmtPasso->close(); // Feche a consulta preparada

                if (!$resultPasso) {
                    // Exibe uma mensagem de erro em caso de falha na inserção de etapas de preparo
                    $erro = "Ocorreu um erro durante a inserção das etapas de preparo.";
                    break; // Saia do loop em caso de erro
                }
            }
        }

        // Verifica se todas as inserções foram bem-sucedidas
        if (empty($erro)) {
            // Redireciona para a página de sucesso após todas as inserções bem-sucedidas
            header("Location: ../index/index.php");
            exit();
        }
    } else {
        // Exibe uma mensagem de erro em caso de falha na inserção da receita
        $erro = "Ocorreu um erro durante a inserção da receita.";
    }
} else {
    // Se o formulário não foi submetido via POST, redireciona para a página de erro
    header("Location: ../cadastro-receitas/erro.php?erro=" . urlencode($erro));
    exit();
}
?>
