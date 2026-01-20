<?php

//                  Autenticação com Bearer Token
// Tem que subir o servidor e fazer o request de outra aba no terminal

// Definição de token válido (em sistemas reais isso viria de um banco de dados ou serviço de autenticação)
$tokenValido = "123456ABCDEF";

// Captura todos os headers da requisição
$headers = getallheaders();

// Verifica se o header Authorization existe
if (!isset($headers['Authorization'])) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Token não fornecido.";
    exit;
}

// Extrai o token enviado
[$tipo, $tokenRecebido] = explode(" ", $headers['Authorization'], 2);

// Verifica se é Bearer e se o token é válido
if ($tipo !== "Bearer" || $tokenRecebido !== $tokenValido) {
    header('HTTP/1.0 403 Forbidden');
    echo "Token inválido.";
    exit;
}

// Se chegou até aqui, o token é válido
echo "Acesso liberado com token válido!";


// Saída:

//$ curl -H "Authorization: Bearer 123456ABCDEF" http://localhost:8000/api.php
//Array
//(
//    [Host] => localhost:8000
//    [User-Agent] => curl/8.14.1
//    [Accept] => */*
//    [Authorization] => Bearer 123456ABCDEF
//)