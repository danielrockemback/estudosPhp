<?php

class SQLServerDatabase implements DatabaseInterface {
    use CrudTrait;

    public function connect() {
        $this->pdo = new PDO("sqlsrv:Server=localhost;Database=teste", "sa", "senha123");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function disconnect() {
        $this->pdo = null;
    }
}
