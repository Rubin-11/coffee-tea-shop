<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BasketsMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('baskets');
        $table
            ->addColumn('user_id', 'integer', [
                'comment' => 'ID пользователя'
            ])
            ->addColumn('product_id', 'integer', [
                'comment' => 'ID товара'
            ])
            ->addColumn('quantity', 'integer', [
                'default' => 1,
                'comment' => 'Количество товара'
            ])
            ->addColumn('price', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'signed' => false,
                'comment' => 'Цена товара на момент добавления в корзину'
            ])
            ->addColumn('status', 'string', [
                'limit' => 10,
                'default' => 'active',
                'comment' => 'Статус позиции в корзине'
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true
            ])
            // Индексы
            ->addIndex(['user_id'])
            ->addIndex(['product_id'])
            ->addIndex(['user_id', 'product_id', 'status'], [
                'unique' => true,
                'name' => 'unique_user_product_active_basket'
            ])
            ->addIndex(['status'])
            // Внешние ключи
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении пользователя удаляем его корзину
                    'update' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении товара удаляем его из корзины
                    'update' => 'CASCADE'
                ]
            )
            ->create();

        // Проверка статуса
        $this->execute(
            "ALTER TABLE baskets ADD CONSTRAINT status_check 
                CHECK (status IN ('active', 'ordered'));"
        );

        // Проверка количества и цены
        $this->execute(
            'ALTER TABLE baskets 
            ADD CONSTRAINT quantity_positive CHECK (quantity > 0),
            ADD CONSTRAINT price_non_negative CHECK (price >= 0)'
        );

        // Триггер для обновления цены товара при добавлении в корзину
        $this->execute(
            'CREATE OR REPLACE FUNCTION update_basket_price()
            RETURNS TRIGGER AS $$
            BEGIN
                -- Устанавливаем текущую цену товара
                NEW.price = (SELECT price FROM products WHERE id = NEW.product_id);
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;'
        );

        $this->execute(
            'CREATE TRIGGER update_basket_price_trigger
            BEFORE INSERT ON baskets
            FOR EACH ROW
            EXECUTE FUNCTION update_basket_price();'
        );

        // Триггер для обновления updated_at
        $this->execute('
            CREATE TRIGGER update_baskets_updated_at
            BEFORE UPDATE ON baskets
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();
        ');
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_baskets_updated_at ON baskets');
        $this->execute('DROP TRIGGER IF EXISTS update_basket_price_trigger ON baskets');
        $this->execute('DROP FUNCTION IF EXISTS update_basket_price()');
        $this->execute('ALTER TABLE baskets DROP CONSTRAINT IF EXISTS quantity_positive');
        $this->execute('ALTER TABLE baskets DROP CONSTRAINT IF EXISTS price_non_negative');
        $this->table('baskets')->drop()->save();
    }
}
