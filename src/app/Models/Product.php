<?php

namespace Shop\Rubin11\Models;

use PDO;

class Product
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $statement = $this->pdo->prepare("SELECT * FROM products");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
