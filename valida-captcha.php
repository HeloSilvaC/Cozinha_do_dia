<?php
   session_start();
    if ($_POST["captcha"] == $_SESSION["palavra"]){
        echo "<h1>Voce Acertou</h1>";
    }else{
        echo "<h1>Voce nao acertou!</h1>";
        echo "<a href='entrar.php'></a>";
    }
?>