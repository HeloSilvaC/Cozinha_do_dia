<?php

include "../entrar/conectar-bd.php";

$idUsuario = isset($_SESSION["id"]);
$receitaId = $_POST['id'];

date_default_timezone_set('America/Sao_Paulo');

$nomeReceita = $_POST["nome-receita"];
$tempoPreparo = $_POST["tempo-preparo"];
$porcoes = $_POST["porcoes"];
$categoria = $_POST["categoria"];
$data = date("d/m/Y H:i");

$sqlUpdateReceita = "UPDATE receitas SET nome=?, tempo_preparo=?, porcoes=?, categoria=?, data_atualizada=? WHERE id=?";
$stmtUpdateReceita = $con->prepare($sqlUpdateReceita);
$stmtUpdateReceita->bind_param("siissi", $nomeReceita, $tempoPreparo, $porcoes, $categoria, $data, $receitaId);
$stmtUpdateReceita->execute();
$stmtUpdateReceita->close();

if (!empty($_FILES['uploadfile']['name'])) {
    
    $sqlImagem = "SELECT filename FROM image WHERE receita_id = $receitaId";
    $resultImagem = $con->query($sqlImagem);

    if ($resultImagem->num_rows > 0) {
        $rowImagem = $resultImagem->fetch_assoc();
        $filenameToDelete = $rowImagem['filename'];

        $filePath = "C:/xampp/htdocs/Receitas/imagem/" . $filenameToDelete;
        
        if (file_exists($filePath)) {
            unlink($filePath); 
        }

        $uploadedFiles = $_FILES['uploadfile'];
        $filename = $uploadedFiles['name'];
        $cleanedFilename = preg_replace("/[^a-zA-Z0-9.]/", "_", $filename);
        $tempname = $uploadedFiles['tmp_name'];
        $directoryPath = "C:/xampp/htdocs/Receitas/imagem/";

        
        if (move_uploaded_file($tempname, $directoryPath . $cleanedFilename)) {
          
            $sqlUpdateImage = "UPDATE image SET filename = ? WHERE receita_id = ?";
            $stmtUpdateImage = $con->prepare($sqlUpdateImage);
            $stmtUpdateImage->bind_param("si", $cleanedFilename, $receitaId);

            if ($stmtUpdateImage->execute()) {
                $stmtUpdateImage->close();
            } 
        } 
    } 
}

for ($i = 0; $i < count($_POST["modo-preparo"]); $i++) {
    $idPassoModoPreparo = $_POST["id-passo-modo-preparo"][$i];
    $passoModoPreparo = $_POST["modo-preparo"][$i];

    $sqlUpdateModoPreparo = "UPDATE modo_preparo SET passo=? WHERE id=? AND receita_id=?";
    $stmtUpdateModoPreparo = $con->prepare($sqlUpdateModoPreparo);
    $stmtUpdateModoPreparo->bind_param("sii", $passoModoPreparo, $idPassoModoPreparo, $receitaId);
    $stmtUpdateModoPreparo->execute();
    $stmtUpdateModoPreparo->close();
}

for ($i = 0; $i < count($_POST["nome-ingrediente"]); $i++) {
    $idIngrediente = $_POST["id-ingrediente"][$i];
    $nomeIngrediente = $_POST["nome-ingrediente"][$i];
    $quantidadeIngrediente = $_POST["quantidade-ingrediente"][$i];
    $unidadeIngrediente = $_POST["unidade-ingrediente"][$i];

    $sqlUpdateIngrediente = "UPDATE ingredientes SET nome=?, quantidade=?, unidade=? WHERE id=? AND receita_id=?";
    $stmtUpdateIngrediente = $con->prepare($sqlUpdateIngrediente);
    $stmtUpdateIngrediente->bind_param("sisii", $nomeIngrediente, $quantidadeIngrediente, $unidadeIngrediente, $idIngrediente, $receitaId);
    $stmtUpdateIngrediente->execute();
    $stmtUpdateIngrediente->close();
}

$con->close();

header("Location: pesquisa-receita.php?id=$receitaId");
exit();
