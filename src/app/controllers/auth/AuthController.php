<?php

namespace Shop\Rubin11\controllers\auth;

use Shop\Rubin11\models\User;

class AuthController
{

    public function __construct(
        public private(set) string $email = '',
        public private(set) string $password = '',
    ) {
        $this->email = $_POST['email'] ?? '';
        $this->password = $_POST['password'] ?? '';
    }

    // Показать форму регистрации
    public function showRegisterForm()
    {
        include __DIR__ . '/../../../views/auth/register.php';
    }

    // Обработка регистрации
    public function register()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors = 'Некорректный email';
            include __DIR__ . '/../../../views/auth/register.php';
            return;
        }
        if (strlen($this->password) < 6) {
            $errors = 'Пароль должен быть не менее 6 символов';
            include __DIR__ . '/../../../views/auth/register.php';
            return;
        }
        // Проверка наличия пользователя по email
        if (User::findByEmail($this->email)) {
            $errors = 'Email уже занят';
            include __DIR__ . '/../../../views/auth/register.php';
            return;
        }

        $user = new User(
            email: $this->email,
            password_hash: password_hash($this->password, PASSWORD_DEFAULT),
        );

        if ($user->save()) {
            header('Location: /login');
            exit;
        } else {
            $errors = 'Ошибка регистрации';
            include __DIR__ . '/../../../views/auth/register.php';
            return;
        }
    }

    public function showLoginForm()
    {
        include __DIR__ . '/../../../views/auth/logit.php';
    }

    public function login()
    {
        $user = User::findByEmail($this->email);
        if ($user && $user->verifyPassword($this->password)) {
            $_SESSION['user_id'] = $user->id;
            header('Location: /');
            exit;
        } else {
            $errors = 'Неверный email или пароль';
            include __DIR__ . '/../../../views/auth/logit.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function dashboard()
{
    include __DIR__ . '/../../../views/dashboard.php';
}

public static function isAuthenticated()
{
    return isset($_SESSION['user_id']);
}
}
