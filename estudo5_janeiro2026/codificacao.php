<?php

//                              4 - Codificação e Decodificação
// Codificação e decodificação servem para transformar dados em formatos seguros ou diferentes, seja para transmitir,
// armazenar ou proteger informações.


//                              Funções comuns no PHP

// urlencode e urldecode: usados para codificar/decodificar strings em URLs.
$texto = "Sistema Saci PHP";
$codificado = urlencode($texto);

// Saída: Daniel+Copilot+PHP
echo $codificado . PHP_EOL;

$decodificado = urldecode($codificado);

// Saída: Daniel Copilot PHP
echo $decodificado . PHP_EOL;


// htmlspecialchars() e html_entity_decode(): Protegem contra XSS (inserção de código HTML/JS malicioso).
$entrada = "<script>alert('Hacker');</script>";

// Saída segura: &lt;script&gt;alert('Hacker');&lt;/script&gt;
echo htmlspecialchars($entrada . PHP_EOL);

// Saída: <b>Negrito</b>
echo html_entity_decode("&lt;b&gt;Negrito&lt;/b&gt;" . PHP_EOL);


// base64_encode() e base64_decode(): Usados para transformar dados binários em texto seguro (ex: imagens, tokens, senhas).
$senha = "Coqueiro01";
$codificada = base64_encode($senha);

// Saída: Q29xdWVpcm8wMQ==
echo "Senha codificada {$codificada}" . PHP_EOL;

$decodificada = base64_decode($codificada);

// Saída: Coqueiro01
echo $decodificada  . PHP_EOL;


// json_encode() e json_decode(): Transformam arrays/objetos em JSON e vice-versa (muito usado em APIs).

$dados = ["nome" => "DanielBorges", "isAdmin" => True];
$json = json_encode($dados);

// Saída: {"nome":"Daniel","isAdmin":true}
echo $json  . PHP_EOL;

$array = json_decode($json, true);

// Saída: Daniel
echo $array['nome'] . PHP_EOL;

