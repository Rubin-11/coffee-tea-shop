<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AttributeValuesMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('attribute_values');
        $table
            ->addColumn('attribute_id', 'integer', [
                'comment' => 'ID атрибута'
            ])
            ->addColumn('value', 'text', [
                'comment' => 'Значение атрибута'
            ])
            // Индексы
            ->addIndex(['attribute_id'])
            ->addIndex(['attribute_id', 'value'], [
                'unique' => true,
                'name' => 'unique_attribute_value'
            ])
            // Внешние ключи
            ->addForeignKey(
                'attribute_id',
                'attributes',
                'id',
                [
                    'delete' => 'CASCADE', // При удалении атрибута удаляем его значения
                    'update' => 'CASCADE'
                ]
            )

            ->create();
    }
}
