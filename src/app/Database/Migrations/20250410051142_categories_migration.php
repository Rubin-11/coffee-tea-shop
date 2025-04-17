<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CategoriesMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('categories');
        $table
            ->addColumn('name', 'string', [
                'length' => 100,
                'null' => false,
                'comment' => 'Название категории (регистронезависимый)'
            ])
            ->addColumn('slug', 'string', [
                'length' => 100,
                'null' => false,
                'comment' => 'URL категории (регистронезависимый)'
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'comment' => 'Флаг активности'
            ])
            ->addColumn('meta_title', 'text', [
                'null' => true,
                'comment' => 'SEO заголовок'
            ])
            ->addColumn('meta_description', 'text', [
                'null' => true,
                'comment' => 'SEO описание'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'comment' => 'Дата обновления'
            ])
            // Индексы
            ->addIndex(['slug'], [
                'unique' => true
            ])
            ->addIndex(['is_active'])
            ->create();

        // Меняем типы name и slug на citext
        $this->execute('ALTER TABLE categories ALTER COLUMN name TYPE citext;');
        $this->execute('ALTER TABLE categories ALTER COLUMN slug TYPE citext;');

        // Проверка длины meta_title
        $this->execute(
            'ALTER TABLE categories 
            ADD CONSTRAINT meta_title_length 
            CHECK (LENGTH(meta_title) <= 60 OR meta_title IS NULL)'
        );

        // Триггер для updated_at
        $this->execute(
            'CREATE TRIGGER update_categories_updated_at
            BEFORE UPDATE ON categories
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_categories_updated_at ON categories');
        $this->table('categories')->drop()->save();
    }
}
