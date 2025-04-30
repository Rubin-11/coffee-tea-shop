<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Shop\Rubin11\Router;
use Shop\Rubin11\Controllers\ProductController;

$router = new Router();

require_once __DIR__ . '/../app/routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI']); 
