<?php
// Inclua o arquivo de conexão com o banco de dados
include "../entrar/conectar-bd.php";

// Verifica se o formulário foi submetido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário e aplica filtragem
    $nomeReceita = filter_input(INPUT_POST, "nome-receita");
    $ingredientes = $_POST["ingredientes"];
    $quantidades = $_POST["quantidades"];
    $unidades = $_POST["unidades"];
    $modoPreparo = $_POST["modo-preparo"];
    $tempoPreparo = $_POST["tempo-preparo"];
    $porcoes = $_POST["porcoes"];
    $categoria = $_POST["categoria"];

    // Inicia uma transação
    $con->begin_transaction();

    try {
        // Insere os dados da receita no banco de dados
        $sql = "INSERT INTO receitas (nome, tempo_preparo, porcoes, categoria) VALUES (?, ?, ?, ?)";
        $stmtReceita = $con->prepare($sql);
        $stmtReceita->bind_param("ssis", $nomeReceita, $tempoPreparo, $porcoes, $categoria);
        $resultReceita = $stmtReceita->execute();

        // Verifica se a inserção da receita foi bem-sucedida
        if ($resultReceita) {
            // Obtém o ID da receita recém-inserida
            $receitaId = $stmtReceita->insert_id;

            $filename = $_FILES['uploadfile']['name'];
            $cleanedFilename = preg_replace("/[^a-zA-Z0-9.]/", "_", $filename);
            $tempname = $_FILES['uploadfile']['tmp_name'];

            // Caminho absoluto completo para o diretório de imagens
            $directoryPath = "C:/xampp/htdocs/Receitas/imagem/";

            // Mover o arquivo para o diretório desejado
            if (move_uploaded_file($tempname, $directoryPath . $filename)) {
                // Inserir informações no banco de dados
                $query = "INSERT INTO image (filename, receita_id) VALUES (?, ?)";
                $stmtImagem = $con->prepare($query);
                $stmtImagem->bind_param("si", $filename, $receitaId);
                $resultImagem = $stmtImagem->execute();


                if (!$resultImagem) {
                    throw new Exception("Erro ao inserir informações da imagem no banco de dados.");
                }

                $stmtImagem->close();
            } else {
                throw new Exception("Erro ao mover o arquivo de imagem para o diretório.");
            }

            // Loop para inserir ingredientes usando uma consulta preparada
            for ($i = 0; $i < count($ingredientes); $i++) {
                $sql = "INSERT INTO ingredientes (receita_id, nome, quantidade, unidade) VALUES (?, ?, ?, ?)";
                $stmtIngredientes = $con->prepare($sql);
                $stmtIngredientes->bind_param("issi", $receitaId, $ingredientes[$i], $quantidades[$i], $unidades[$i]);
                $resultIngredientes = $stmtIngredientes->execute();

                if (!$resultIngredientes) {
                    throw new Exception("Erro na inserção de ingredientes.");
                }

                $stmtIngredientes->close(); // Feche a consulta preparada
            }

            // Loop para inserir modo de preparo na ordem correta
            for ($ordem = 0; $ordem < count($modoPreparo); $ordem++) {
                $passo = $modoPreparo[$ordem];
                $ordemMaisUm = $ordem + 1;
                $sql = "INSERT INTO modo_preparo (receita_id, passo, ordem) VALUES (?, ?, ?)";
                $stmtPasso = $con->prepare($sql);
                $stmtPasso->bind_param("isi", $receitaId, $passo, $ordemMaisUm);
                $resultPasso = $stmtPasso->execute();

                if (!$resultPasso) {
                    throw new Exception("Erro na inserção de etapas de preparo.");
                }

                $stmtPasso->close(); // Feche a consulta preparada
            }


            // Commit se todas as operações foram bem-sucedidas
            $con->commit();

            // Redireciona para a página de sucesso após todas as inserções bem-sucedidas
            header("Location: ../index/index.php");
            exit();
        } else {
            // Exibe uma mensagem de erro em caso de falha na inserção da receita
            throw new Exception("Erro na inserção da receita.");
        }
    } catch (Exception $e) {
        // Em caso de erro, realiza o rollback
        $con->rollback();

        // Exibe uma mensagem de erro
        echo "Erro: " . $e->getMessage();
        exit();
    }
} else {
    // Se o formulário não foi submetido via POST, redireciona para a página de erro
    header("Location: ../cadastro-receitas/erro.php?erro=Formulário não submetido via POST.");
    exit();
}
