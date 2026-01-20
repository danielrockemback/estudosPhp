<?php

//                                  1 - SESSIONS
// Sessions permitem armazenar informações do usuário enquanto ele navega entre diferentes páginas.

// Iniciando a Session, o start sempre deve ficar no início do arquivo
session_start();

// Recuperando os valores que foi enviado pelo forms pelo méthodo POST
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


// Checando se o usuário é um administrador do sistema para poder entrar numa página restrita
if ($usuario === 'DanielBorges' && $senha === 'Coqueiro01') {
    // Setando os valores na session
    $_SESSION['logado'] = true;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['admin'] = true;

    // Redirecionado para a página de administracao
    header("Location: administracao.php");

} else {
    echo "Usuário ou senha inválidos.";
}

//                              3 - Global Arrays (Superglobais)
// O PHP possui superglobais, arrays especiais que estão sempre disponíveis em qualquer escopo.
// Eles são usados para acessar dados do usuário, do servidor e do ambiente.


// Pegar parâmetros passados pela URL
// Exemplo de url: saci.sistemacoqueiro.php?nome=DanielBorges&idade=30
echo $_GET['usuario'];   // Saída: Daniel
echo $_GET['idade'];  // Saída: 30

// Dados enviados via formulário POST
echo $_POST['email'];

// Informações do servidor
echo $_SERVER['HTTP_USER_AGENT']; // Navegador do usuário
echo $_SERVER['REMOTE_ADDR'];     // IP do usuário

//                     Principais superglobais:

//  $_GET : dados enviados pela URL (query string).
//  $_POST : dados enviados via formulário com methodo POST.
//  $_SESSION : dados armazenados na sessão.
//  $_COOKIE : dados armazenados no navegador do usuário.
//  $_FILES : arquivos enviados via formulário.
//  $_SERVER : informações do servidor e ambiente.
//  $_REQUEST → mistura de $_GET, $_POST e $_COOKIE.