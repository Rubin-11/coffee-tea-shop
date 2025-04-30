<?php

namespace Shop\Rubin11;

use Shop\Rubin11\Controllers\ProductController;

class Router
{
    private $routes = [];
    private $currentGroupMiddleware = null;

    /**
     * Добавить маршрут
     * @param string $method HTTP-метод (GET, POST и т.д.)
     * @param string $pattern URI-шаблон (например, '/products/{id}')
     * @param callable $handler Обработчик (например, [ProductController::class, 'show'])
     */
    public function addRoute($method, $pattern, $handler)
    {
        $route = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler
        ];

        // Если есть активный middleware для группы, добавляем его в маршрут
        if ($this->currentGroupMiddleware !== null) {
            $route['middleware'] = $this->currentGroupMiddleware;
        }

        $this->routes[] = $route;
    }

    /**
     * Группировка маршрутов с общими параметрами
     * @param array $attributes Атрибуты группы (middleware и т.д.)
     * @param callable $callback Функция с определением маршрутов
     */
    public function group(array $attributes, callable $callback)
    {
        // Сохраняем предыдущий middleware
        $previousMiddleware = $this->currentGroupMiddleware;

        // Устанавливаем новый middleware для группы
        if (isset($attributes['middleware'])) {
            $this->currentGroupMiddleware = $attributes['middleware'];
        }

        // Выполняем callback для определения маршрутов
        $callback($this);
        
        // Восстанавливаем предыдущий middleware
        $this->currentGroupMiddleware = $previousMiddleware;
    }

    /**
     * Сопоставить URI с маршрутом и вызвать обработчик
     * @param string $uri Текущий URI
     * @return mixed Результат выполнения обработчика
     */
    public function dispatch($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $route['pattern']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Проверяем middleware, если он есть
                if (isset($route['middleware'])) {
                    $middlewareClass = $route['middleware'];
                    $middleware = new $middlewareClass();
                    return $middleware->handle($params, function($request) use ($route, $params) {
                        return $this->executeHandler($route['handler'], $params);
                    });
                }
                
                return $this->executeHandler($route['handler'], $params);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Выполнить обработчик маршрута
     * @param mixed $handler Обработчик маршрута
     * @param array $params Параметры маршрута
     * @return mixed Результат выполнения обработчика
     */
    private function executeHandler($handler, $params)
    {
        if (is_array($handler)) {
            $controller = new $handler[0]();
            $method = $handler[1];
            return call_user_func_array([$controller, $method], $params);
        }
        
        return call_user_func_array($handler, $params);
    }
}
