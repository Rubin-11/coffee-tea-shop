<?php

namespace Shop\Rubin11\controllers\auth;

use Shop\Rubin11\models\User;
use Shop\Rubin11\validators\Validator;
use Shop\Rubin11\config\Paths;
use Shop\Rubin11\view\ViewRenderer;

class AuthController
{
    /**
     * @var ViewRenderer Объект для рендеринга шаблонов
     */
    private ViewRenderer $view;

    /**
     * Конструктор контроллера
     */
    public function __construct()
    {
        $this->view = new ViewRenderer();
    }

    // Установка сообщений
    private function setFlashMessage(string $type, string $message): void
    {
        $_SESSION['flash_messages'][$type] = $message;
    }

    // Получение сообщений
    private function getFlashMessages(): array
    {
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }

    // Генерация CSRF-токена
    private function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Проверка CSRF-токена
    private function validateCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Подготовка общих данных для шаблонов
     * 
     * @param array $data Дополнительные данные
     * @return array Объединенные данные
     */
    private function prepareViewData(array $data = []): array
    {
        return array_merge([
            'csrf_token' => $this->generateCsrfToken(),
            'flashMessages' => $this->getFlashMessages()
        ], $data);
    }

    // Показать форму регистрации
    public function showRegisterForm()
    {
        $this->view->display('auth/register', $this->prepareViewData());
    }

    // Обработка регистрации
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->display('auth/register', $this->prepareViewData());
            return;
        }

        // Проверка CSRF-токена
        if (!isset($_POST['csrf_token']) || !$this->validateCsrfToken($_POST['csrf_token'])) {
            $errors = ['csrf' => 'Ошибка безопасности. Попробуйте еще раз.'];
            $this->view->display('auth/register', $this->prepareViewData(['errors' => $errors]));
            return;
        }

        $validator = new Validator($_POST);
        $validator->required('email', 'Email обязателен')
            ->required('password', 'Пароль обязателен')
            ->email('email', 'Некорректный email')
            ->unique('email', 'users', 'email', 'Email уже занят')
            ->minLength('password', 6, 'Пароль должен быть не менее 6 символов');

        // Если валидация не прошла, выводим ошибки
        if ($validator->failed()) {
            $this->view->display('auth/register', $this->prepareViewData([
                'errors' => $validator->errors,
                'formData' => $validator->data
            ]));
            return;
        }

        // Если валидация прошла, создаем пользователя
        $data = $validator->data;
        $user = new User(
            email: $data['email'],
            password_hash: password_hash($data['password'], PASSWORD_DEFAULT),
        );

        // Если пользователь успешно сохранен, перенаправляем на страницу входа
        if ($user->save()) {
            $this->setFlashMessage('success', 'Вы успешно зарегистрировались');
            header('Location: /login');
            exit;
        } else {
            $errors = ['general' => 'Ошибка регистрации'];
            $this->view->display('auth/register', $this->prepareViewData([
                'errors' => $errors,
                'formData' => $data
            ]));
            return;
        }
    }

    // Показать форму входа
    public function showLoginForm()
    {
        $this->view->display('auth/logit', $this->prepareViewData());
    }

    // Обработка входа
    public function login()
    {
        // Если запрос не POST, отображаем форму входа
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->display('auth/logit', $this->prepareViewData());
            return;
        }

        // Проверка CSRF-токена
        if (!isset($_POST['csrf_token']) || !$this->validateCsrfToken($_POST['csrf_token'])) {
            $errors = ['csrf' => 'Ошибка безопасности. Попробуйте еще раз.'];
            $this->view->display('auth/logit', $this->prepareViewData(['errors' => $errors]));
            return;
        }

        // Валидация данных
        $validator = new Validator($_POST);
        $validator->required('email', 'Email обязателен')
            ->required('password', 'Пароль обязателен')
            ->email('email', 'Некорректный email');

        // Если валидация не прошла, выводим ошибки
        if ($validator->failed()) {
            $this->view->display('auth/logit', $this->prepareViewData([
                'errors' => $validator->errors,
                'formData' => $validator->data
            ]));
            return;
        }

        // Если валидация прошла, проверяем данные
        $data = $validator->data;
        $user = User::findByEmail($data['email']);

        // Если пользователь найден и пароль верен, авторизуем
        if ($user && $user->verifyPassword($data['password'])) {
            $_SESSION['user_id'] = $user->id;
            $this->setFlashMessage('success', 'Вы успешно вошли в систему');
            header('Location: /test-protected');
            exit;
        } else {
            $errors = ['auth' => 'Неверный email или пароль'];
            $this->view->display('auth/logit', $this->prepareViewData([
                'errors' => $errors,
                'formData' => $data
            ]));
        }
    }

    // Обработка выхода
    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    // Показать панель управления
    public function dashboard()
    {
        $this->view->display('auth/dashboard', $this->prepareViewData());
    }

    // Проверка аутентификации
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    // Получение текущего пользователя
    public static function getCurrentUser(): ?User
    {
        if (self::isAuthenticated()) {
            return User::findById($_SESSION['user_id']);
        }
        return null;
    }
}
