<?php

//                                          Segurança

/**

; Nunca exponha erros ao usuário final
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/errors.log

; Esconde a versão do PHP nos headers HTTP
expose_php = Off

; Limita o tamanho de uploads e inputs
upload_max_filesize = 2M
post_max_size = 8M
max_input_vars = 1000

; Sessão segura
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
session.cookie_samesite = "Lax"

; Desabilita funções perigosas se não precisar
disable_functions = exec,passthru,shell_exec,system,proc_open,popen

Em desenvolvimento, display_errors = On é ok. Em produção, jamais. Vazar stack traces entrega estrutura do código para atacantes.
 */


//                                          SQL Injection: Atacante injeta SQL via input.

$pdo = true;
$email = 'danielborges@grupocoqueiro';

// Vulnerável
$sql = "SELECT * FROM users WHERE email = '$email'";
// Se $email for: ' OR '1'='1
// A query vira: SELECT * FROM users WHERE email = '' OR '1'='1'

// Seguro: Usamos o prepare ara resolver o sql injection
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->bindvalue(':email', $email);
$stmt->execute();

//                    XSS: Atacante injeta JavaScript que executa no navegador de outro usuário.

// Vulnerável (se $comment vier do usuário)
echo "<div>$comment</div>";
// Se $comment for: <script>fetch('/api/steal?c='+document.cookie)</script>

// Seguro
echo '<div>' . htmlspecialchars($comment, ENT_QUOTES, 'UTF-8') . '</div>';


//                    CSRF: Atacante engana o usuário logado a fazer uma ação em outro site. Solução: token CSRF.

// Ao gerar o formulário
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
echo '<input type="hidden" name="csrf" value="' . $_SESSION['csrf_token'] . '">';

// Ao receber o POST
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf'] ?? '')) {
    throw new RuntimeException('Token CSRF inválido');
}

// Importante: use hash_equals() e não ===. Isso previne timing attacks (ataques que medem tempo de resposta para adivinhar strings).

//                                          Path Traversal: Atacante acessa arquivos fora do diretório permitido.

// Vulnerável
$file = $_GET['file'];
readfile("/uploads/$file"); // Se $file = "../../etc/passwd"

// Seguro
$file = basename($_GET['file']);  // Remove qualquer ../
$path = realpath("/uploads/$file");

if ($path === false || !str_starts_with($path, '/uploads/')) {
    throw new RuntimeException('Arquivo inválido');
}
readfile($path);


//                                          Command Injection: Atacante injeta comandos shell.

// Vulnerável
$filename = $_GET['file'];
exec("convert $filename output.png"); // Se $filename = "a.jpg; rm -rf /"

// Seguro
exec('convert ' . escapeshellarg($filename) . ' output.png');
// Melhor ainda: não chame shell, use bibliotecas PHP


//                                          Mass Assignment: Atacante passa campos que não deveriam ser editáveis.

// Vulnerável
$user->fill($_POST); // Se $_POST tiver 'role' => 'admin'

// Seguro (whitelist explícita)
$allowed = ['name', 'email'];
$data = array_intersect_key($_POST, array_flip($allowed));
$user->fill($data);


//                  Open Redirect: Atacante usa seu site como ponte para redirecionar para sites maliciosos (phishing).

// Vulnerável
$url = $_GET['redirect'];
header("Location: $url"); // Se $url = "https://site-falso.com"

// Seguro (whitelist de domínios)
$allowed = ['meusite.com', 'app.meusite.com'];
$parsed = parse_url($url);

if (!in_array($parsed['host'] ?? '', $allowed, true)) {
    $url = '/'; // Fallback seguro
}
header("Location: $url");


//                        Header Injection (CRLF Injection): Atacante injeta \r\n em headers para forjar respostas HTTP.

// Vulnerável
header('Location: ' . $_GET['url']);
// Se $_GET['url'] = "ok\r\nSet-Cookie: admin=true"

// Seguro: valide ou use funções que já sanitizam
// O próprio header() do PHP 5.1.2+ bloqueia CRLF, mas valide mesmo assim
if (preg_match('/[\r\n]/', $url)) {
    throw new InvalidArgumentException('URL inválida');
}


//                                          Insecure Deserialization
// Nunca use unserialize() em dados do usuário. Pode executar código arbitrário via magic methods.

// NUNCA faça isso
$data = unserialize($_COOKIE['user_data']);

// Use JSON em vez disso
$data = json_decode($_COOKIE['user_data'], true);


//          SSRF (Server-Side Request Forgery): Atacante força seu servidor a fazer requisições para endereços internos.

// Vulnerável
$content = file_get_contents($_GET['url']);
// Se $_GET['url'] = "http://169.254.169.254/..." (metadata AWS)
// ou "file:///etc/passwd"

// Seguro: valide protocolo e host
$url = $_GET['url'];
$parsed = parse_url($url);

if (!in_array($parsed['scheme'] ?? '', ['http', 'https'], true)) {
    throw new InvalidArgumentException('Protocolo inválido');
}

// Bloqueie IPs privados e locais
$ip = gethostbyname($parsed['host']);
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
    throw new InvalidArgumentException('Host não permitido');
}


//                                  Security Headers (via header() ou web server)

// Impede o navegador de "adivinhar" o content-type
header('X-Content-Type-Options: nosniff');

// Impede que seu site seja embutido em iframes (clickjacking)
header('X-Frame-Options: DENY');

// Força HTTPS por 1 ano (só use quando já estiver 100% em HTTPS)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

// Content Security Policy (a mais poderosa contra XSS)
header("Content-Security-Policy: default-src 'self'; script-src 'self'");

// Controla o que é enviado no Referer
header('Referrer-Policy: strict-origin-when-cross-origin');


//                          Os 6 ataques principais:
//
//  SQL Injection → prepared statements
//  XSS → htmlspecialchars() no output
//  CSRF → token com hash_equals()
//  Path Traversal → basename() + realpath() + validação do prefixo
//  Command Injection → evite shell, ou use escapeshellarg()
//  Mass Assignment → whitelist de campos