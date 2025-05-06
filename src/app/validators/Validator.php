<?php

namespace Shop\Rubin11\validators;

use Shop\Rubin11\database\Database;

class Validator
{
    public function __construct(
        public private(set) array $data,
        public private(set) array $errors = [],
    ){
    }

    // Проверка обязательности поля
    public function required(string $field, ?string $message = null): self
    {
        if (empty($this->data[$field])) {
            $this->errors[$field] = $message ?? "Поле $field обязательно";
        }
        return $this;
    }

    // Проверка email
    public function email(string $field, ?string $message = null): self
    {
        if(empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "Поле {$field} должно быть валидным email";
        }
        return $this;
    }

    // Проверка минимальной длины
    public function minLength(string $field, int $length, ?string $message = null): self 
    {
        if (empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?? "Поле {$field} должно быть не короче {$length} символов";
        }
        return $this;
    }

    // Проверка на соответствие шаблону
    public function pattern(string $field, string $pattern, ?string $message = null): self
    {
        if (empty($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->errors[$field] = $message ?? "Поле {$field} имеет неправильный формат";
        }
        return $this;
    }

    // Проверка уникальности
    public function unique(string $field, string $table, string $column, ?string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $pdo = Database::getPdo();
            $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :value");
            $stmt->execute(['value' => $this->data[$field]]);

            if ($stmt->fetchColumn() > 0) {
                $this->errors[$field] = $message ?? "Поле {$field} должно быть уникальным";
            }
        }
        return $this;
    }

    // Проверка на наличие ошибок
    public function failed(): bool
    {
        return !empty($this->errors);
    }
}
