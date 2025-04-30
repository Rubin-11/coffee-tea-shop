<?php

namespace Shop\Rubin11\controllers;
// require_once __DIR__ . '/../../../vendor/autoload.php';

use Shop\Rubin11\Models\Product;
use PDO;

class ProductController
{
  private $productModel;
  // public function __construct()
  // {
  //   $dsn = "pgsql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
  //   $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
  //   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //   $this->productModel = new Product($pdo);
  // }

  public function index()
  {
    // die('index');
    // $products = $this->productModel->getAll();
    include __DIR__ . '/../../Views/products/auth/logit.php';
// или другой актуальный путь к view
  }
}
