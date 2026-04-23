<?php

// Conexão com SQL Server
$dsn = 'sqlsrv:Server=localhost;Database=minha_base';
$username = 'sa';
$password = 'senha_forte';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Lança exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Retorna arrays associativos
    PDO::ATTR_EMULATE_PREPARES => false,                // Prepared statements reais, ele fica mais seguro contra sql injection
];

$email = 'danielborges@grupocoqueiro.com.br';

try {
    $pdo = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    throw new RuntimeException('Falha na conexão com o banco');
}


//                          Select com prepare
$sql = 'SELECT id, name, email FROM users WHERE email = :email';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

$stmt->execute();

// Se quiser apenas um registro vamos usar o fetch
$user = $stmt->fetch();

// Todos os registros
$users = $stmt->fetchAll();
// --------------------------------------------------------------------------------------------------------------------

// Placeholders posicionais
$sql = 'SELECT id, name FROM users WHERE status = ? AND created_at > ?';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, 1, PDO::PARAM_INT);
$stmt->bindValue(2, 1, PDO::PARAM_INT);
$stmt->execute();

$users = $stmt->fetchAll();

// --------------------------------------------------------------------------------------------------------------------

//                                          Insert, update e delete

// INSERT
$sql = 'INSERT INTO users (name, email, created_at) VALUES (:name, :email, GETDATE())';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'name' => 'Daniel Borges',
    'email' => 'danielborges@grupocoqueiro.com'
]);

// recuperando o último id inserido
$novoId = $pdo->lastInsertId();

// UPDATE
$sql = 'UPDATE users SET name = :name WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $novoId, PDO::PARAM_INT);
$stmt->bindValue(':name', 'Daniel Borges', PDO::PARAM_STR);

$stmt->execute();

$linhasAfetadas = $stmt->rowCount();

// DELETE
$sql = 'DELETE FROM users WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $novoId, PDO::PARAM_INT);

$stmt->execute();


// --------------------------------------------------------------------------------------------------------------------

// Transação: Nós usamos o conceito do ACID para tudo ocorrer certo nas transações

try {
    $pdo->beginTransaction();

    $pdo->prepare('UPDATE accounts SET balance = balance - :valor WHERE id = :id')
        ->execute(['valor' => 100, 'id' => 1]);

    $pdo->prepare('UPDATE accounts SET balance = balance + :valor WHERE id = :id')
        ->execute(['valor' => 100, 'id' => 2]);

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();

    throw $e;
}

//  Bindando Tipos Explicitamente

$stmt = $pdo->prepare('SELECT * FROM products WHERE price > :price LIMIT :limit');
$stmt->bindValue(':price', 99.90, PDO::PARAM_STR);
$stmt->bindValue(':limit', 10, PDO::PARAM_INT);

$stmt->execute();

// --------------------------------------------------------------------------------------------------------------------

//                                             Modos de Fetch

// Retorna objeto stdClass
$stmt->fetch(PDO::FETCH_OBJ);

// Hidrata direto numa classe (muito útil em DDD)
$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
$user = $stmt->fetch();

// Retorna só a primeira coluna (útil para COUNT, SUM)
$total = $stmt->fetchColumn();


//                                             Query com IN (...) dinâmico
$ids = [1, 2, 3, 4];
$placeholders = implode(',', array_fill(0, count($ids), '?'));

$sql = "SELECT * FROM users WHERE id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($ids);