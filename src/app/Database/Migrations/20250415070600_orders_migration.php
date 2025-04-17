<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class OrdersMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('orders');
        $table
            // Основная информация
            ->addColumn('user_id', 'integer', [
                'comment' => 'ID пользователя'
            ])
            ->addColumn('delivery_address_id', 'integer', [
                'null' => true,
                'comment' => 'ID адреса доставки'
            ])
            ->addColumn('is_delivery', 'boolean', [
                'default' => true,
                'comment' => 'Требуется доставка'
            ])
            ->addColumn('total_price', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'signed' => false,
                'comment' => 'Общая стоимость заказа'
            ])
            ->addColumn('status', 'string', [
                'limit' => 16,
                'default' => 'pending',
                'comment' => 'Статус заказа'
            ])
            ->addColumn('payment_method', 'string', [
                'limit' => 8,
                'comment' => 'Способ оплаты'
            ])
            ->addColumn('payment_status', 'string', [
                'limit' => 8,
                'default' => 'pending',
                'comment' => 'Статус оплаты'
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true
            ])

            // Индексы
            ->addIndex(['user_id'])
            ->addIndex(['delivery_address_id'])
            ->addIndex(['status'])
            ->addIndex(['payment_status'])
            ->addIndex(['created_at'])

            // Внешние ключи
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'RESTRICT', // Запрещаем удаление пользователя с заказами
                    'update' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'delivery_address_id',
                'user_addresses',
                'id',
                [
                    'delete' => 'SET NULL', // При удалении адреса устанавливаем NULL
                    'update' => 'CASCADE'
                ]
            )

            ->create();

        // Проверка цены
        $this->execute(
            'ALTER TABLE orders 
            ADD CONSTRAINT total_price_positive CHECK (total_price > 0)'
        );

        // Проверки для ENUM-столбцов
        $this->execute(
            "ALTER TABLE orders ADD CONSTRAINT status_check CHECK (status IN ('pending', 'completed', 'canceled'));"
        );
        $this->execute(
            "ALTER TABLE orders ADD CONSTRAINT payment_method_check CHECK (payment_method IN ('card', 'cash'));"
        );
        $this->execute(
            "ALTER TABLE orders ADD CONSTRAINT payment_status_check CHECK (payment_status IN ('pending', 'paid'));"
        );

        // Триггер для updated_at
        $this->execute(
            'CREATE TRIGGER update_orders_updated_at
            BEFORE UPDATE ON orders
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );

        // Триггер для проверки согласованности статусов
        $this->execute(
            'CREATE OR REPLACE FUNCTION check_order_status_consistency()
            RETURNS TRIGGER AS $$
            BEGIN
                -- Если заказ отменен, статус оплаты должен быть pending
                IF NEW.status = \'canceled\' AND NEW.payment_status = \'paid\' THEN
                    RAISE EXCEPTION \'Canceled order cannot have paid payment status\';
                END IF;
                
                -- Если заказ завершен, статус оплаты должен быть paid
                IF NEW.status = \'completed\' AND NEW.payment_status = \'pending\' THEN
                    RAISE EXCEPTION \'Completed order must have paid payment status\';
                END IF;
                
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;'
        );

        $this->execute(
            'CREATE TRIGGER check_order_status_consistency_trigger
            BEFORE INSERT OR UPDATE ON orders
            FOR EACH ROW
            EXECUTE FUNCTION check_order_status_consistency();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_orders_updated_at ON orders');
        $this->execute('DROP TRIGGER IF EXISTS check_order_status_consistency_trigger ON orders');
        $this->execute('DROP FUNCTION IF EXISTS check_order_status_consistency()');
        $this->execute('ALTER TABLE orders DROP CONSTRAINT IF EXISTS total_price_positive');
        $this->execute('ALTER TABLE orders DROP CONSTRAINT IF EXISTS status_check');
        $this->execute('ALTER TABLE orders DROP CONSTRAINT IF EXISTS payment_method_check');
        $this->execute('ALTER TABLE orders DROP CONSTRAINT IF EXISTS payment_status_check');
        $this->table('orders')->dropForeignKey('user_id')->save();
        $this->table('orders')->dropForeignKey('delivery_address_id')->save();
        $this->table('orders')->drop()->save();
    }
}
