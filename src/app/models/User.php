<?php

namespace Shop\Rubin11\models;

use Shop\Rubin11\database\Database;
use PDO;

final class User
{
    public function __construct(
        public private(set) ?int $id = null,
        public private(set) ?string $first_name = null,
        public private(set) ?string $last_name = null,
        public private(set) string $email = '',
        public private(set) ?string $phone = null,
        public private(set) ?string $password_hash = null,
        public private(set) bool $is_admin = false,
        public private(set) bool $is_active = true,
        public private(set) ?string $created_at = null,
        public private(set) ?string $updated_at = null,
    ) {}

    public static function findByEmail(string $email): ?self // Поиск пользователя по email
    {
        $pdo = Database::getPdo();
        $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1'); // Подготавливаем запрос
        $statement->execute(['email' => $email]); // Выполняем запрос
        $data = $statement->fetch(PDO::FETCH_ASSOC); // Получаем данные
        if ($data) { // Если пользователь найден
            $user = new self(); // Создаем новый объект
            
            foreach ($data as $key => $value) {  // Заполняем свойства объекта
                $user->$key = $value;
            }
            
            return $user;
        }
        return null;
    }

    /**
     * Поиск пользователя по ID
     * 
     * @param int $id ID пользователя
     * @return User|null Объект пользователя или null, если не найден
     */
    public static function findById(int $id): ?self
    {
        $pdo = Database::getPdo();
        $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $user = new self();
            foreach ($data as $key => $value) {
                $user->$key = $value;
            }
            return $user;
        }
        
        return null;
    }

    public function save(): bool // Сохранение пользователя
    {
        $pdo = Database::getPdo();
        $statement = $pdo->prepare(
            'INSERT INTO users (email, password_hash) 
            VALUES (:email, :password_hash) RETURNING id'
        );
        try {
            return $statement->execute([
                'email' => $this->email,
                'password_hash' => $this->password_hash,
            ]);
        } catch (\Throwable $th) { // Перехватываем ошибки
            throw $th;
        }
    }

    public function verifyPassword(string $password): bool // Проверка пароля
    {
        return password_verify($password, $this->password_hash);
    }
}
