<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class OrderItemsMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('order_items');
        $table
            // Основная информация
            ->addColumn('order_id', 'integer', [
                'comment' => 'ID заказа'
            ])
            ->addColumn('product_id', 'integer', [
                'comment' => 'ID товара'
            ])
            ->addColumn('quantity', 'integer', [
                'default' => 1,
                'comment' => 'Количество товара'
            ])
            ->addColumn('price_at_purchase', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'signed' => false,
                'comment' => 'Цена на момент покупки'
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true
            ])
            // Индексы
            ->addIndex(['order_id'])
            ->addIndex(['product_id'])
            ->addIndex(['order_id', 'product_id'], [
                'unique' => true,
                'name' => 'unique_order_product'
            ])

            // Внешние ключи
            ->addForeignKey(
                'order_id',
                'orders',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении заказа удаляем его позиции
                    'update' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'delete' => 'RESTRICT', // Запрещаем удаление товара, который есть в заказе
                    'update' => 'CASCADE'
                ]
            )

            ->create();

        // Проверка количества и цены
        $this->execute(
            'ALTER TABLE order_items 
            ADD CONSTRAINT quantity_positive CHECK (quantity > 0),
            ADD CONSTRAINT price_at_purchase_non_negative CHECK (price_at_purchase >= 0)'
        );

        // Триггер для обновления updated_at
        $this->execute('
            CREATE TRIGGER update_order_items_updated_at
            BEFORE UPDATE ON order_items
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();
        ');

        // Триггер для обновления общей стоимости заказа
        $this->execute(
            'CREATE OR REPLACE FUNCTION update_order_total_price()
            RETURNS TRIGGER AS $$
            BEGIN
                -- Обновляем общую стоимость заказа
                UPDATE orders
                SET total_price = (
                    SELECT SUM(quantity * price_at_purchase)
                    FROM order_items
                    WHERE order_id = NEW.order_id
                )
                WHERE id = NEW.order_id;
                
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;'
        );

        $this->execute(
            'CREATE TRIGGER update_order_total_price_trigger
            AFTER INSERT OR UPDATE OR DELETE ON order_items
            FOR EACH ROW
            EXECUTE FUNCTION update_order_total_price();'
        );

        // Триггер для перевода товаров из корзины в заказ
        $this->execute(
            'CREATE OR REPLACE FUNCTION create_order_from_basket()
            RETURNS TRIGGER AS $$
            BEGIN
                -- Обновляем статус товаров в корзине на "ordered"
                UPDATE baskets
                SET status = \'ordered\'
                WHERE user_id = NEW.user_id AND status = \'active\';
                
                -- Вставляем товары из корзины в заказ
                INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
                SELECT NEW.id, product_id, quantity, price
                FROM baskets
                WHERE user_id = NEW.user_id AND status = \'ordered\';
                
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;'
        );

        $this->execute(
            'CREATE TRIGGER create_order_from_basket_trigger
            AFTER INSERT ON orders
            FOR EACH ROW
            EXECUTE FUNCTION create_order_from_basket();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_order_items_updated_at ON order_items');
        $this->execute('DROP TRIGGER IF EXISTS update_order_total_price_trigger ON order_items');
        $this->execute('DROP TRIGGER IF EXISTS create_order_from_basket_trigger ON orders');
        $this->execute('ALTER TABLE order_items DROP CONSTRAINT IF EXISTS quantity_positive');
        $this->execute('ALTER TABLE order_items DROP CONSTRAINT IF EXISTS price_at_purchase_non_negative');
        $this->execute('ALTER TABLE order_items DROP CONSTRAINT IF EXISTS unique_order_product');
        $this->table('order_items')->drop()->save();
    }
}
