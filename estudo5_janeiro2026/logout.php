<?php

session_start();

// Apagando os dados salvos na sessão e encerrando ela
session_unset();
session_destroy();

// Redirecionando para o login
header("Location: login.php");