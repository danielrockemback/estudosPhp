<?php

//                      5- Funções de Rede

//              Autenticação HTTP

// Definição de credenciais válidas
$usuariosValidos = [
    "admin" => "1234",
    "daniel" => "php2026"
];


// Verificar se o navegador enviou credenciais
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    // Se não tiver enviado, ele vai abrir uma caixinha para enviar
    header('WWW-Authenticate: Basic realm="Área Restrita"');
    header('HTTP/1.0 401 Unauthorized');

    echo "Autenticação necessária.";

    exit;

} else {
    $usuario = $_SERVER['PHP_AUTH_USER'];
    $senha   = $_SERVER['PHP_AUTH_PW'];

    // Validar credenciais
    if (!array_key_exists($usuario, $usuariosValidos) || $usuariosValidos[$usuario] !== $senha) {
        // Usuário sem permissão
        header('HTTP/1.0 403 Forbidden');
        echo "Acesso negado.";
        exit;
    }
}

//  file_get_contents
//  Normalmente, file_get_contents() é usado para ler o conteúdo de um arquivo local
//  Mas se você passar uma URL (http:// ou https://), ele abre uma conexão HTTP e traz o conteúdo da resposta como uma string.

// Cotação do dólar comercial no Banco Central
$url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.1/dados/ultimos/1?formato=json";

// Fazendo a requisição para api utilizando o file_get_contents
$resposta = file_get_contents($url);

// Decodificando a resposta e transformando num array de objetos
$dados = json_decode($resposta);

// Acessando os atributos do objeto
$cotacao = $dados[0]->valor;
$data = $dados[0]->data;

echo "Cotação do dólar em {$data}: R$ {$cotacao}" . PHP_EOL;


// Usando cURL para requisições mais complexas, cURL é mais poderoso: suporta POST, autenticação, headers customizados, etc.

// URL da API de piadas
$url = "https://official-joke-api.appspot.com/random_joke";

// Inicializa cURL
$ch = curl_init($url);

// Configurações para retornar como string e ignorando a verificação se o HTTPS é válido
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Executa requisição
$resposta = curl_exec($ch);

// Fecha conexão
curl_close($ch);

// Decodifica JSON
$dados = json_decode($resposta);

// Exibe piada
if (isset($dados)) {
    echo $dados->setup . PHP_EOL;
    echo $dados->punchline . PHP_EOL;

} else {
    echo "Não foi possível obter uma piada." . PHP_EOL;
}


// Definição de credenciais válidas
$usuariosValidos = [
    "admin" => "1234",
    "daniel" => "php2026"
];

// Verificar se o navegador enviou credenciais
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Área Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Autenticação necessária.";
    exit;
} else {
    $usuario = $_SERVER['PHP_AUTH_USER'];
    $senha = $_SERVER['PHP_AUTH_PW'];

    // Validar credenciais
    if (!array_key_exists($usuario, $usuariosValidos) || $usuariosValidos[$usuario] !== $senha) {
        header('HTTP/1.0 403 Forbidden');
        echo "Acesso negado.";
        exit;
    } else {
        echo "Bem-vindo, " . htmlspecialchars($usuario);
    }
}


//                      5- Funções de Rede
//  file_get_contents
//  Normalmente, file_get_contents() é usado para ler o conteúdo de um arquivo local
//  Mas se você passar uma URL (http:// ou https://), ele abre uma conexão HTTP e traz o conteúdo da resposta como uma string.

// Cotação do dólar comercial no Banco Central
$url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.1/dados/ultimos/1?formato=json";

// Fazendo a requisição para api utilizando o file_get_contents
$resposta = file_get_contents($url);

// Decodificando a resposta e transformando num array de objetos
$dados = json_decode($resposta);

// Acessando os atributos do objeto
$cotacao = $dados[0]->valor;
$data = $dados[0]->data;

echo "Cotação do dólar em {$data}: R$ {$cotacao}" . PHP_EOL;


// Usando cURL para requisições mais complexas, cURL é mais poderoso: suporta POST, autenticação, headers customizados, etc.

// URL da API de piadas
$url = "https://official-joke-api.appspot.com/random_joke";

// Inicializa cURL
$ch = curl_init($url);

// Configurações para retornar como string e ignorando a verificação se o HTTPS é válido
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Executa requisição
$resposta = curl_exec($ch);

// Fecha conexão
curl_close($ch);

// Decodifica JSON
$dados = json_decode($resposta);

// Exibe piada
if (isset($dados)) {
    echo $dados->setup . PHP_EOL;
    echo $dados->punchline . PHP_EOL;

} else {
    echo "Não foi possível obter uma piada." . PHP_EOL;
}


// Definição de credenciais válidas
$usuariosValidos = [
    "admin" => "1234",
    "daniel" => "php2026"
];

// Verificar se o navegador enviou credenciais
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Área Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Autenticação necessária.";
    exit;
} else {
    $usuario = $_SERVER['PHP_AUTH_USER'];
    $senha = $_SERVER['PHP_AUTH_PW'];

    // Validar credenciais
    if (!array_key_exists($usuario, $usuariosValidos) || $usuariosValidos[$usuario] !== $senha) {
        header('HTTP/1.0 403 Forbidden');
        echo "Acesso negado.";
        exit;
    } else {
        echo "Bem-vindo, " . htmlspecialchars($usuario);
    }
}



//  file_get_contents
//  Normalmente, file_get_contents() é usado para ler o conteúdo de um arquivo local
//  Mas se você passar uma URL (http:// ou https://), ele abre uma conexão HTTP e traz o conteúdo da resposta como uma string.

// Cotação do dólar comercial no Banco Central
$url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.1/dados/ultimos/1?formato=json";

// Fazendo a requisição para api utilizando o file_get_contents
$resposta = file_get_contents($url);

// Decodificando a resposta e transformando num array de objetos
$dados = json_decode($resposta);

// Acessando os atributos do objeto
$cotacao = $dados[0]->valor;
$data = $dados[0]->data;

echo "Cotação do dólar em {$data}: R$ {$cotacao}" . PHP_EOL;


// Usando cURL para requisições mais complexas, cURL é mais poderoso: suporta POST, autenticação, headers customizados, etc.

// URL da API de piadas
$url = "https://official-joke-api.appspot.com/random_joke";

// Inicializa cURL
$ch = curl_init($url);

// Configurações para retornar como string e ignorando a verificação se o HTTPS é válido
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Executa requisição
$resposta = curl_exec($ch);

// Fecha conexão
curl_close($ch);

// Decodifica JSON
$dados = json_decode($resposta);

// Exibe piada
if (isset($dados)) {
    echo $dados->setup . PHP_EOL;
    echo $dados->punchline . PHP_EOL;

} else {
    echo "Não foi possível obter uma piada." . PHP_EOL;
}


// Definição de credenciais válidas
$usuariosValidos = [
    "admin" => "1234",
    "daniel" => "php2026"
];

// Verificar se o navegador enviou credenciais
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Área Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Autenticação necessária.";
    exit;
} else {
    $usuario = $_SERVER['PHP_AUTH_USER'];
    $senha = $_SERVER['PHP_AUTH_PW'];

    // Validar credenciais
    if (!array_key_exists($usuario, $usuariosValidos) || $usuariosValidos[$usuario] !== $senha) {
        header('HTTP/1.0 403 Forbidden');
        echo "Acesso negado.";
        exit;
    } else {
        echo "Bem-vindo, " . htmlspecialchars($usuario);
    }
}






