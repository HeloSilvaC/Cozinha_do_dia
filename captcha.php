<?php
session_start(); // Inicia a sessão
header("Content-type: image/jpeg"); // Define o tipo do arquivo

function captcha($largura, $altura, $tamanho_fonte, $quantidade_letras)
{
    $imagem = imagecreate($largura, $altura); // Define a largura e a altura da imagem
    
    // Define as cores personalizadas
    $fundo = imagecolorallocate($imagem, 0xDF, 0x90, 0x1A); // Laranja (#DF901A) como cor de fundo
    $texto = imagecolorallocate($imagem, 0xFF, 0xFF, 0xFF); // Branco (#FFF) como cor do texto
    
    // Preenche o fundo com a cor definida
    imagefilledrectangle($imagem, 0, 0, $largura, $altura, $fundo);
    
    // Define a palavra conforme a quantidade de letras definidas no parâmetro
    $palavra = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, $quantidade_letras);

    $_SESSION["palavra"] = $palavra; // Atribui para a sessão a palavra gerada

    for ($i = 0; $i < $quantidade_letras; $i++) {
        imagettftext(
            $imagem,
            $tamanho_fonte,
            rand(-20, 20),
            20 + ($tamanho_fonte * $i),
            $altura / 1.5,
            $texto,
            'ROBOTOMONO-BOLD.TTF',
            substr($palavra, $i, 1)
        );
    }
    imagejpeg($imagem); // Gera a imagem
    imagedestroy($imagem); // Limpa a imagem da memória
}

$largura = 150; // Largura da imagem do captcha
$altura = 50;   // Altura da imagem do captcha
$tamanho_fonte = 20; // Tamanho da fonte utilizada no captcha
$quantidade_letras = 6; // Quantidade de letras que o captcha terá
captcha($largura, $altura, $tamanho_fonte, $quantidade_letras);
// Executa a função captcha passando os parâmetros recebidos
?>
