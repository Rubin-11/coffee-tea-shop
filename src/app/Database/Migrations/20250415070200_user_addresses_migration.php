<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserAddressesMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('user_addresses');
        $table
            ->addColumn('user_id', 'integer', [
                'comment' => 'ID пользователя'
            ])
            ->addColumn('country', 'string', [
                'length' => 100,
                'comment' => 'Страна'
            ])
            ->addColumn('city', 'string', [
                'length' => 100,
                'comment' => 'Город'
            ])
            ->addColumn('street', 'string', [
                'length' => 200,
                'comment' => 'Улица'
            ])
            ->addColumn('flat', 'string', [
                'length' => 50,
                'null' => true,
                'comment' => 'Квартира/офис'
            ])
            ->addColumn('postal_code', 'string', [
                'length' => 20,
                'comment' => 'Почтовый индекс'
            ])
            ->addColumn('is_primary', 'boolean', [
                'default' => false,
                'comment' => 'Основной адрес'
            ])
            ->addColumn('delivery_notes', 'text', [
                'null' => true,
                'comment' => 'Примечания для доставки'
            ])
            // Временные метки
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            // Индексы
            ->addIndex(['user_id', 'is_primary'])
            // Внешние ключи
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении пользователя удаляем его адреса
                    'update' => 'CASCADE'
                ]
            )
            ->create();

        $this->execute(
            'CREATE UNIQUE INDEX IF NOT EXISTS uniq_primary_address 
            ON user_addresses (user_id) 
            WHERE is_primary = TRUE;'
        );

        // Триггер для updated_at
        $this->execute(
            'CREATE TRIGGER update_user_addresses_updated_at
            BEFORE UPDATE ON user_addresses
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_user_addresses_updated_at ON user_addresses'); // Триггер для updated_at
        $this->table('user_addresses')->drop()->save(); // Удаление таблицы
        $this->execute('DROP INDEX IF EXISTS uniq_primary_address;'); // Удаление индекса
    }
}
