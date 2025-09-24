<?php

// Trait
// Um trait é um bloco de código reutilizável que pode ser injetado em várias classes. Diferente da herança, você pode usar vários traits em uma mesma classe.
// Como o PHP não aceita herança multipla, usar os traits é uma boa ideia para esses casos

trait CrudTrait {
    private $pdo;
    private $stmt;

    public function insert(string $table, array $data): bool {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($data);
    }

    public function update(string $table, array $data, string $where, array $params = []): bool {
        $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute(array_merge($data, $params));
    }

    public function delete(string $table, string $where, array $params = []): bool {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($params);
    }

    public function select(string $sql, array $params = []): array {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
