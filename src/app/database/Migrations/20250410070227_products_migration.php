<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProductsMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('products');
        $table
            ->addColumn('name', 'text', [
                'comment' => 'Название товара'
            ])
            ->addColumn('slug', 'string', [
                'comment' => 'URL товара'
            ])
            ->addColumn('description', 'text', [
                'comment' => 'Описание товара'
            ])
            ->addColumn('price', 'decimal', [
                'precision' => 10, // Общее количество цифр
                'scale' => 2,      // Количество цифр после запятой
                'signed' => false, // Не может быть отрицательным
                'comment' => 'Цена товара'
            ])
            ->addColumn('old_price', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'null' => true,
                'comment' => 'Старая цена товара'
            ])
            ->addColumn('stock', 'integer', [
                'default' => 0,
                'signed' => false,
                'comment' => 'Количество на складе'
            ])
            ->addColumn('weight', 'integer', [
                'comment' => 'Вес товара в граммах',
            ])
            ->addColumn('category_id', 'integer', [
                'comment' => 'ID категории'
            ])
            // SEO
            ->addColumn('meta_title', 'string', [
                'limit' => 60,
                'null' => true,
                'comment' => 'SEO заголовок, длина - 60 символов, может быть null'
            ])
            ->addColumn('meta_description', 'text', [
                'null' => true,
                'comment' => 'SEO описание, может быть null'
            ])
            // Статусы и рейтинг
            ->addColumn('rating', 'decimal', [
                'precision' => 3,
                'scale' => 2,
                'default' => 0,
                'signed' => false,
                'comment' => 'Рейтинг товара от 0.00–5.00'
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'comment' => 'Товар доступен для заказа, по умолчанию - true'
            ])
            ->addColumn('is_featured', 'boolean', [
                'default' => false,
                'comment' => 'Показывать на главной, по умолчанию - false'
            ])
            // Временные метки
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ])
            // Индексы
            ->addIndex(['slug'], [
                'unique' => true
            ])
            ->addIndex(['category_id'])
            ->addIndex(['is_active'])
            ->addIndex(['is_featured'])
            // Внешние ключи
            ->addForeignKey(
                'category_id',
                'categories',
                'id',
                [
                    'delete' => 'RESTRICT', // Удаление запрещено
                    'update' => 'CASCADE' // Обновление разрешено
                ]
            )
            ->create();

        // Меняем тип slug на citext
        $this->execute('ALTER TABLE products ALTER COLUMN slug TYPE citext;');

        // Проверки
        $this->execute(
            'ALTER TABLE products 
        ADD CONSTRAINT stock_non_negative CHECK (stock >= 0), -- Не может быть отрицательным
        ADD CONSTRAINT rating_range CHECK (rating BETWEEN 0 AND 5), -- Оценка от 0 до 5
        ADD CONSTRAINT price_non_negative CHECK (price >= 0), -- Цена не может быть отрицательной
        ADD CONSTRAINT old_price_check CHECK (old_price >= 0 OR old_price IS NULL) -- Старая цена не может быть отрицательной'
        );

        // Триггер для updated_at
        $this->execute(
            'CREATE TRIGGER update_products_updated_at
            BEFORE UPDATE ON products
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_products_updated_at ON products');
        $this->table('products')->drop()->save();
    }
}
