<?php

namespace Shop\Rubin11\controllers;


class MainController
{
    public function index()
    {
        include __DIR__ . '/../../views/main/main.php';
    }

    /**
     * Тестовая защищенная страница
     * Доступна только авторизованным пользователям
     */
    public function testProtected()
    {
        include __DIR__ . '/../../views/protected/test.php';
    }
}
