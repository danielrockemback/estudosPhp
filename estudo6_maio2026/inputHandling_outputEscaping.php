<?php

// Input Handling

//  $_GET      // Query string (?name=joao)
//  $_POST     // Corpo da requisição (form data)
//  $_COOKIE   // Cookies enviados pelo cliente
//  $_SERVER   // Headers HTTP, IP, método, etc.
//  $_FILES    // Uploads de arquivo
//  $_REQUEST  // NUNCA USE (mistura GET, POST, COOKIE)
//
// Para JSON (API)
$json = file_get_contents('php://input');
$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);


// Validação com filter_input e filter_var

// Validar email
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if ($email === false || $email === null) {
    throw new InvalidArgumentException('Email inválido');
}

// Validar inteiro com range
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 0, 'max_range' => 120]
]);

// Validar URL
$url = filter_input(INPUT_POST, 'website', FILTER_VALIDATE_URL);

// Validar IP
$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

// Validar float
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

// filter_input retorna:
// - o valor filtrado se válido
// - false se inválido
// - null se o campo não existir

// Verifique os DOIS casos
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
if ($age === false || $age === null) {
    throw new InvalidArgumentException('Idade invalida');
}

//  Sanitização vs Validação
//  Dois conceitos diferentes que costumam confundir:
//  Validação: o dado está correto? Retorna true/false.
//  Sanitização: remove ou escapa caracteres perigosos.

$input = "name'); DELETE FROM items; SELECT \* FROM items WHERE 'a'='a";
// Validação: rejeita se inválido
$email = filter_var($input, FILTER_VALIDATE_EMAIL);

// Sanitização: tenta "limpar"
$clean = filter_var($input, FILTER_SANITIZE_EMAIL);


//              Output Escaping
// Regra de ouro: escape no momento da saída e conforme o contexto. O mesmo dado precisa ser escapado de formas diferentes dependendo de onde vai.

$value = '<script>alert("xss")</script>';

// Contexto HTML (texto dentro de tags)
echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
// Saída: &lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;

// Contexto HTML attribute (dentro de atributos)
echo '<input value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '">';

// Contexto URL (query string)
echo '<a href="/search?q=' . urlencode($value) . '">';

// Contexto JavaScript (dentro de <script>)
echo '<script>var x = ' . json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP) . ';</script>';

// Assinatura
//htmlspecialchars(string $string, int $flags, string $encoding);

// Sempre use ENT_QUOTES (escapa aspas simples também)
//htmlspecialchars($x, ENT_QUOTES, 'UTF-8');

// A partir do PHP 8.1, ENT_QUOTES é o default, mas seja explícito


//                              Segurança de Sessão

/**
    Como Funciona uma Sessão em PHP
    Fluxo básico:

    Usuário faz login
    PHP gera um ID único (ex.: abc123xyz)
    Esse ID é enviado ao navegador como cookie PHPSESSID
    Os dados ficam no servidor (arquivo, Redis, banco)
    A cada requisição, o navegador envia o cookie, PHP carrega os dados
**/

session_start();
$_SESSION['user_id'] = 42;
// PHP cria um arquivo tipo /tmp/sess_abc123xyz com os dados serializados

// Configuração Segura da Sessão

// Cookie acessível apenas via HTTP (não JavaScript) → previne XSS roubar sessão
ini_set('session.cookie_httponly', '1');

// Cookie só é enviado em HTTPS
ini_set('session.cookie_secure', '1');

// Rejeita IDs de sessão não gerados pelo servidor → previne fixation
ini_set('session.use_strict_mode', '1');

// Cookie não é enviado em requisições cross-site → previne CSRF
ini_set('session.cookie_samesite', 'Lax');

// Só aceita sessão via cookie (não via URL)
ini_set('session.use_only_cookies', '1');
ini_set('session.use_trans_sid', '0');

// Tempo de vida do cookie (0 = até fechar o navegador)
ini_set('session.cookie_lifetime', '0');

// Tempo de vida dos dados no servidor (segundos)
ini_set('session.gc_maxlifetime', '1800'); // 30 min


/**
    O que cada flag previne
    cookie_httponly: JavaScript não consegue ler o cookie via document.cookie. Sem isso, um XSS pode roubar a sessão.
    cookie_secure: cookie só trafega em HTTPS. Sem isso, quem estiver na mesma rede WiFi pode capturar.
    use_strict_mode: se o navegador enviar um ID de sessão que o servidor não gerou, o PHP descarta. Previne session fixation.
    cookie_samesite: previne CSRF. Lax é o melhor balanço entre segurança e usabilidade.
 */


//  Regenerar ID de Sessão

function login(int $userId): void
{
    // Regenera o ID e apaga a sessão antiga
    session_regenerate_id(true);

    $_SESSION['user_id'] = $userId;
    $_SESSION['logged_in_at'] = time();
}

function logout(): void
{
    // Limpa os dados
    $_SESSION = [];

    // Destrói o cookie no navegador
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Destrói no servidor
    session_destroy();
}


// Idle Timeout:  Sessão expira após X minutos sem atividade.

function validateSessionTimeout(): void
{
    $now = time();
    $absoluteLimit = 8 * 3600;    // 8 horas
    $idleLimit = 30 * 60;         // 30 minutos

    // Absolute timeout
    if (isset($_SESSION['logged_in_at']) &&
        ($now - $_SESSION['logged_in_at']) > $absoluteLimit) {
        logout();
        throw new RuntimeException('Sessão expirada');
    }

    // Idle timeout
    if (isset($_SESSION['last_activity']) &&
        ($now - $_SESSION['last_activity']) > $idleLimit) {
        logout();
        throw new RuntimeException('Sessão inativa');
    }

    $_SESSION['last_activity'] = $now;
}