<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProductAttributesMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('product_attributes');

        $table
            ->addColumn('product_id', 'integer', [
                'comment' => 'ID товара'
            ])
            ->addColumn('attribute_value_id', 'integer', [
                'comment' => 'ID значения атрибута'
            ])
            // Внешние ключи
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении товара удаляем его атрибуты
                    'update' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'attribute_value_id',
                'attribute_values',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении значения атрибута удаляем связи с товарами
                    'update' => 'CASCADE'
                ]
            )
            // Индексы
            ->addIndex(['product_id', 'attribute_value_id'], [
                'unique' => true
            ])
            ->create();
    }
}
