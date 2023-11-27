<?php
session_start();

if (!isset($_SESSION["estaLogado"]) || $_SESSION["estaLogado"] !== true) {
    header("Location: ../entrar.php");
    exit();
}
?>