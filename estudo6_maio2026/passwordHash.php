<?php

// Password Hashing API

/**
    * Senhas são dados extremamente sensíveis. Se seu banco vazar (e bancos vazam), as senhas precisam estar protegidas
    * de um jeito que mesmo com o hash em mãos, o atacante não consiga descobrir a senha original em tempo útil.
    *
    * Hash vs Criptografia
    * Muita gente confunde. São coisas diferentes:
    * Criptografia: reversível. Com a chave, você decodifica.
    * Hash: irreversível. Transforma entrada em um valor fixo que não pode ser revertido.
    *
    * Senha: "minhasenha123"
    * Hash:  "$2y$12$KIZ.ZzbZJKGx2Kn3..."
    *
    * Do hash, você NÃO consegue voltar para "minhasenha123".
 */


// Aqui vamos usar o ARGON que é um hash moderno e bem robusto e vamos configurar para ficar pesado se por acaso a pessoa tentar atacar
$senha = 'Coqueiro01';

// Requer PHP com suporte a Argon2 (--with-password-argon2)
$hash = password_hash($senha, PASSWORD_ARGON2ID, [
    'memory_cost' => 65536,  // 64 MB de RAM
    'time_cost'   => 4,      // 4 iterações
    'threads'     => 1,      // 1 thread
]);

$hash = password_hash('minha_senha', PASSWORD_ARGON2ID, $hash);

// Para salvar a senha no banco de dados é interessante usar um nvarchar(255) para salvar o hash corretamente


//                          Segurança no Ciclo Request/Response
// Sem HTTPS, tudo que vimos até aqui é em vão. Cookie httponly, token CSRF, senha hashada, nada disso ajuda se o atacante pode ler o tráfego na rede.

// No nível PHP (fallback)
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $url", true, 301);
    exit;
}

// Melhor: faça no web server (nginx/apache)
// nginx: return 301 https://$host$request_uri;

// Header HSTS (força o navegador a lembrar por 1 ano)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');


//  Validação da Requisição

final class RequestGuard
{
    public function validate(\Request $request): void
    {
        // 1. Método HTTP esperado
        if (!in_array($request->method(), ['GET', 'POST', 'PUT', 'DELETE'], true)) {
            throw new MethodNotAllowedException();
        }

        // 2. Content-Type para POST/PUT
        if (in_array($request->method(), ['POST', 'PUT'], true)) {
            $contentType = $request->header('Content-Type') ?? '';
            if (!str_contains($contentType, 'application/json') &&
                !str_contains($contentType, 'multipart/form-data') &&
                !str_contains($contentType, 'application/x-www-form-urlencoded')) {
                throw new UnsupportedMediaTypeException();
            }
        }

        // 3. Tamanho da requisição (DoS protection)
        $contentLength = (int) ($request->header('Content-Length') ?? 0);
        if ($contentLength > 10 * 1024 * 1024) { // 10MB
            throw new PayloadTooLargeException();
        }

        // 4. CSRF token (exceto GET)
        if ($request->method() !== 'GET') {
            $this->validateCsrfToken($request);
        }
    }
}

// Rate Limiting: Previne ataques de força bruta e abuso. Exemplo simples com Redis:

final class RateLimiter
{
    public function __construct(private readonly Redis $redis) {}

    public function check(string $key, int $maxAttempts, int $windowSeconds): void
    {
        $attempts = (int) $this->redis->incr($key);

        if ($attempts === 1) {
            $this->redis->expire($key, $windowSeconds);
        }

        if ($attempts > $maxAttempts) {
            $ttl = $this->redis->ttl($key);
            throw new TooManyRequestsException("Tente novamente em {$ttl} segundos");
        }
    }
}

// Uso no login
$limiter->check("login:{$ip}", 5, 300);   // 5 tentativas em 5 minutos
$limiter->check("login:{$email}", 5, 900); // 5 tentativas em 15 minutos por email


// Cookies Seguros: Todo cookie além do de sessão também precisa de configuração:

setcookie('preferences', $value, [
    'expires'  => time() + 3600,
    'path'     => '/',
    'domain'   => '.example.com',
    'secure'   => true,        // só HTTPS
    'httponly' => true,        // não acessível via JS
    'samesite' => 'Lax',       // previne CSRF
]);

//                      Armazenamento de Dados Sensíveis

/**
    Antes de armazenar, classifique:
    Públicos: nome, título de perfil. Sem proteção especial.
    Privados: email, telefone. Proteja com controle de acesso no banco.
    Sensíveis: CPF, endereço, dados médicos. Criptografia em repouso.
    Críticos: senhas, tokens, chaves de API. Hash (senhas) ou criptografia com rotação de chaves.
 */

//  NUNCA no código ou Git. A regra de ouro:

/**
    // .env (NÃO commitado)
    APP_ENCRYPTION_KEY=base64:ABcdef1234567890...

    // Carrega via Symfony DotEnv ou equivalente
    $key = base64_decode($_ENV['APP_ENCRYPTION_KEY']);

    Em produção:

    AWS KMS / Azure Key Vault / Google Secret Manager
    HashiCorp Vault
    Variáveis de ambiente do orquestrador (Kubernetes Secrets)
 */

// Credenciais de Banco e APIs

// NUNCA
$pdo = new PDO('sqlsrv:Server=prod-db;Database=app', 'sa', 'senha123');

// SEMPRE via env
$pdo = new PDO(
    $_ENV['DB_DSN'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
);

//  Princípio do menor privilégio

/**
    -- SQL Server
    CREATE LOGIN app_user WITH PASSWORD = 'senha_complexa';
    CREATE USER app_user FOR LOGIN app_user;

    -- Só o necessário
    GRANT SELECT, INSERT, UPDATE, DELETE ON SCHEMA::dbo TO app_user;

    -- Negado explicitamente
    DENY CREATE TABLE, DROP TABLE, ALTER TO app_user;
 */


// Tenha várias defesas no seu sistema

/**
Nunca confie em uma única camada de segurança. Se uma falhar, outras devem proteger.
Exemplo prático de múltiplas camadas para um endpoint crítico (ex.: transferir dinheiro):

    HTTPS (transporte seguro)
    Rate limiting (previne força bruta)
    Autenticação (usuário logado)
    CSRF token (previne ataque cross-site)
    Autorização (pode transferir?)
    Proprietariedade (conta de origem é dele?)
    Validação de input (valor, destino válidos?)
    2FA ou confirmação (para operações críticas)
    Prepared statement (previne SQL Injection)
    Transação atômica (consistência)
    Log de auditoria (rastreabilidade)
    Notificação ao usuário (detecção pós-fato)
 */