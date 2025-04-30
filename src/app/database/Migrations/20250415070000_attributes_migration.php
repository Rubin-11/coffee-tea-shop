<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AttributesMigration extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('attributes');
        $table
            ->addColumn('name', 'text', [
                'comment' => 'Название атрибута'
            ])
            ->addColumn('type', 'text', [
                'comment' => 'Тип атрибута'
            ])
            // Индексы
            ->addIndex(['name'], [
                'unique' => true
            ])
            ->create();

        // Проверка типа атрибута
        $this->execute(
            'ALTER TABLE attributes 
            ADD CONSTRAINT type_check CHECK (type IN (\'text\', \'number\', \'boolean\', \'select\'))'
        );
    }

    public function down(): void
    {
        $this->execute('ALTER TABLE attributes DROP CONSTRAINT type_check'); // Проверка типа атрибута
        $this->table('attributes')->drop()->save(); // Удаление таблицы
    }
}
