<?php

namespace Shop\Rubin11\Middleware;

class AuthMiddleware
{
    /**
     * Обработка запроса
     * @param array $params Параметры запроса
     * @param callable $next Следующий обработчик
     * @return mixed
     */
    public function handle($params, $next)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        return $next($params);
    }   
}