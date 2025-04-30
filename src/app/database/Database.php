<?php

namespace Shop\Rubin11\database;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;
    private string $host;
    private string $dbname;
    private string $user; 
    private string $password;

    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_DATABASE'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        $this->connect();
    }

    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            new self();
        }
        return self::$pdo;
    }

    public function connect(): void
    {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";

            self::$pdo = new PDO(
                $dsn,
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new \RuntimeException("Database connection error");
        }
    }
    // Запрещаем клонирование и восстановление
    private function __clone() {}
    public function __wakeup() {}
}
