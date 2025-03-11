<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Shop\Rubin11\Controllers\ProductController;

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
  case '/':
  case '/products':
    (new ProductController())->index();
    break;
  default:
    http_response_code(404);
    echo '404 Not Found';
    break;
}
