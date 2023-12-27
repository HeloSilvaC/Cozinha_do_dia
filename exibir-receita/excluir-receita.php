<?php

include "../entrar/conectar-bd.php";

$receitaId = $_GET['id'];

// Excluir ingredientes
$sqlIngredientes = "DELETE FROM ingredientes WHERE receita_id = $receitaId";
$resultIngredientes = $con->query($sqlIngredientes);

// Selecionar o nome do arquivo antes de excluir do banco de dados
$sqlImagem = "SELECT filename FROM image WHERE receita_id = $receitaId";
$resultImagem = $con->query($sqlImagem);

if ($resultImagem->num_rows > 0) {
    $rowImagem = $resultImagem->fetch_assoc();
    $filenameToDelete = $rowImagem['filename'];

    // Excluir o arquivo físico da pasta
    $filePath = "C:/xampp/htdocs/Receitas/imagem/" . $filenameToDelete;
    if (file_exists($filePath)) {
        unlink($filePath);
    } else {
        // Lidar com o caso em que o arquivo não existe
        die("O arquivo físico não foi encontrado: " . $filePath);
    }

    // Agora, exclua o registro do banco de dados
    $sqlDeleteImage = "DELETE FROM image WHERE receita_id = $receitaId";
    $resultDeleteImage = $con->query($sqlDeleteImage);

    if (!$resultDeleteImage) {
        die("Erro ao excluir imagens relacionadas: " . $con->error);
    }
}

// Excluir modo de preparo
$sqlModoPreparo = "DELETE FROM modo_preparo WHERE receita_id = $receitaId";
$resultModoPreparo = $con->query($sqlModoPreparo);

// Excluir a receita
$sqlReceita = "DELETE FROM receitas WHERE id = $receitaId";
$resultReceita = $con->query($sqlReceita);

// Verificar se todas as consultas foram bem-sucedidas
if ($resultImagem && $resultIngredientes && $resultModoPreparo && $resultReceita) {
    echo "Deletado com sucesso";
} else {
    echo "Error: " . mysqli_error($con);
}

// Fechar a conexão com o banco de dados
mysqli_close($con);

// Redirecionar para a página inicial após a exclusão
header("Location: ../index/index.php");
exit();
?>
