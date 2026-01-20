<?php

session_start();

// Recuperando da session o status do usuário
$logado = isset($_SESSION['logado']) ?? false;
$usuario = $_SESSION['usuario'] ?? false;
$admin  = $_SESSION['admin'] ?? false;


if (!$logado && !$admin) {
    header("Location: login.php");
    exit;
}

echo "Bem-vindo: {$usuario}";
echo "<br><a href='logout.php'>Sair</a>";