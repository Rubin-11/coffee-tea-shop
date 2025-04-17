<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ReviewsMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('reviews');

        $table
            ->addColumn('user_id', 'integer', ['comment' => 'ID пользователя'])
            ->addColumn('product_id', 'integer', ['comment' => 'ID товара'])
            ->addColumn('rating', 'decimal', [
                'precision' => 2,
                'scale' => 1,
                'comment' => 'Оценка от 1.0 до 5.0'
            ])
            ->addColumn('comment', 'text', [
                'null' => true,
                'comment' => 'Текст отзыва (мин. 10 символов)'
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true
            ])
            ->addIndex(['user_id'])
            ->addIndex(['product_id'])
            ->addIndex(['user_id', 'product_id'], [
                'unique' => true,
                'name' => 'unique_user_product_review'
            ])
            ->addIndex(['rating'])
            ->addIndex(['created_at'])
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE', // При удалении пользователя удаляем его отзывы
                'update' => 'CASCADE'
            ])
            ->addForeignKey('product_id', 'products', 'id', [
                'delete' => 'CASCADE', // При удалении товара удаляем отзывы о нем
                'update' => 'CASCADE'
            ])
            ->create();

        $this->execute(
            'ALTER TABLE reviews 
            ADD CONSTRAINT rating_range CHECK (rating BETWEEN 1.0 AND 5.0), -- Ограничение на оценку
            ADD CONSTRAINT comment_length CHECK (LENGTH(comment) >= 10 OR comment IS NULL) -- Ограничение на длину комментария
            '
        );

        $this->execute(
            'CREATE TRIGGER update_reviews_updated_at
            BEFORE UPDATE ON reviews
            FOR EACH ROW
            EXECUTE FUNCTION update_modified_column();'
        );
    }

    public function down(): void
    {
        $this->execute('DROP TRIGGER IF EXISTS update_reviews_updated_at ON reviews');
        $this->execute('ALTER TABLE reviews DROP CONSTRAINT rating_range');
        $this->execute('ALTER TABLE reviews DROP CONSTRAINT comment_length');
        $this->table('reviews')->drop()->save();
    }
}
