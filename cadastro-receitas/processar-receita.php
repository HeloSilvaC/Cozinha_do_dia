<?php
include "../entrar/conectar-bd.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeReceita = filter_input(INPUT_POST, "nome-receita");
    $ingredientes = $_POST["ingredientes"];
    $quantidades = $_POST["quantidades"];
    $unidades = $_POST["unidades"];
    $modoPreparo = $_POST["modo-preparo"];
    $tempoPreparo = $_POST["tempo-preparo"];
    $porcoes = $_POST["porcoes"];
    $categoria = $_POST["categoria"];

    $con->begin_transaction();

    // Inserir os dados da receita no banco de dados
    $sql = "INSERT INTO receitas (nome, tempo_preparo, porcoes, categoria) VALUES (?, ?, ?, ?)";
    $stmtReceita = $con->prepare($sql);
    $stmtReceita->bind_param("ssis", $nomeReceita, $tempoPreparo, $porcoes, $categoria);
    $resultReceita = $stmtReceita->execute();

    if ($resultReceita) {
        $receitaId = $stmtReceita->insert_id;

        if (!empty($_FILES['uploadfile']['name'])) {
            $filename = $_FILES['uploadfile']['name'];
            $cleanedFilename = preg_replace("/[^a-zA-Z0-9.]/", "_", $filename);
            $tempname = $_FILES['uploadfile']['tmp_name'];

            $directoryPath = "C:/xampp/htdocs/Receitas/imagem/";

            if (move_uploaded_file($tempname, $directoryPath . $filename)) {
                $query = "INSERT INTO image (filename, receita_id) VALUES (?, ?)";
                $stmtImagem = $con->prepare($query);
                $stmtImagem->bind_param("si", $filename, $receitaId);
                $resultImagem = $stmtImagem->execute();

                if (!$resultImagem) {
                    die("Erro ao inserir informações da imagem no banco de dados.");
                }

                $stmtImagem->close();
            } else {
                die("Erro ao mover o arquivo de imagem para o diretório.");
            }
        }

        // Loop para inserir ingredientes usando uma consulta preparada
        for ($i = 0; $i < count($ingredientes); $i++) {
            $sql = "INSERT INTO ingredientes (receita_id, nome, quantidade, unidade) VALUES (?, ?, ?, ?)";
            $stmtIngredientes = $con->prepare($sql);
            $stmtIngredientes->bind_param("issi", $receitaId, $ingredientes[$i], $quantidades[$i], $unidades[$i]);
            $resultIngredientes = $stmtIngredientes->execute();

            if (!$resultIngredientes) {
                die("Erro na inserção de ingredientes.");
            }

            $stmtIngredientes->close();
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
                die("Erro na inserção de etapas de preparo.");
            }

            $stmtPasso->close();
        }

        if ($con->commit()) {
            $mensagem = "true"; // Altere para uma string
            header("Location: cadastro-receita.php?mensagem=" . urlencode($mensagem));
            exit();
        } else {
            $mensagem = "false"; // Altere para uma string
            header("Location: cadastro-receita.php?mensagem=" . urlencode($mensagem));
            exit();
        }
    }
}
