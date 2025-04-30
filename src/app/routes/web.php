<?php

use Shop\Rubin11\controllers\ProductController;
use Shop\Rubin11\controllers\MainController;
use Shop\Rubin11\controllers\auth\AuthController;
use Shop\Rubin11\Middleware\AuthMiddleware;

$router->addRoute('GET', '/', [MainController::class, 'index']);
$router->addRoute('GET', '/products', [ProductController::class, 'index']); // Список товаров
$router->addRoute('GET', '/products/{id}', [ProductController::class, 'show']); // Просмотр товара по id
$router->addRoute('GET', '/login', [AuthController::class, 'showLoginForm']); // Форма входа
$router->addRoute('POST', '/login', [AuthController::class, 'login']); // Вход
$router->addRoute('GET', '/logout', [AuthController::class, 'logout']); // Выход
$router->addRoute('GET', '/register', [AuthController::class, 'showRegisterForm']); // Регистрация
$router->addRoute('POST', '/register', [AuthController::class, 'register']); // Регистрация
// Защищенные маршруты
$router->group(['middleware' => AuthMiddleware::class], function ($router) {
    $router->addRoute('GET', '/admin', [MainController::class, 'admin']); // Админка
    $router->addRoute('GET', '/test-protected', [MainController::class, 'testProtected']); // Тестовая защищенная страница
});