<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UsersMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS citext');

        $table = $this->table('users');
        $table
            ->addColumn('first_name', 'text', [
                'null' => true
            ])
            ->addColumn('last_name', 'text', [
                'null' => true
            ])
            ->addColumn('email', 'string', [
                'length' => 255,
                'null' => false,
                'comment' => 'Email (регистронезависимый)'
            ])
            ->addColumn('phone', 'string', [
                'length' => 20,
                'null' => true,
                'comment' => 'Телефон в формате +7XXXXXXXXXX'
            ])
            ->addColumn('password_hash', 'string', [
                'length' => 60,
                'comment' => 'Хеш пароля (bcrypt, мин. 60 символов)'
            ])
            ->addColumn('is_admin', 'boolean', [
                'default' => false,
                'comment' => 'Флаг администратора'
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'comment' => 'Флаг активности'
            ])
            // Временные метки
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            // Индексы
            ->addIndex(['email'], [
                'unique' => true
            ])
            ->addIndex(['phone'], [
                'unique' => true
            ])
            ->addIndex(['is_active'])
            ->create();

        $this->execute(
            'CREATE UNIQUE INDEX IF NOT EXISTS users_phone_unique_not_null ON users (phone) 
            WHERE phone IS NOT NULL;'
        );

        // Меняем тип email на citext
        $this->execute('ALTER TABLE users ALTER COLUMN email TYPE citext;');

        // Проверка формата телефона
        $this->execute(
            'ALTER TABLE users 
            ADD CONSTRAINT phone_check CHECK (phone ~ \'^\\+7\\d{10}$\' OR phone IS NULL),
            ADD CONSTRAINT password_hash_check CHECK (LENGTH(password_hash) >= 60)'
        );

        // Триггер для updated_at
        $this->execute(
            'CREATE TRIGGER update_users_updated_at
            BEFORE UPDATE ON users
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_users_updated_at ON users');
        $this->table('users')->drop()->save();
    }
}
