<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AttributesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE attribute_values RESTART IDENTITY CASCADE');// 
        $this->execute('TRUNCATE TABLE attributes RESTART IDENTITY CASCADE');
        $data = [
            // Для "Свежеобжаренный кофе"
            ['id' => 1, 'name' => 'Степень обжарки кофе', 'type' => 'select'],
            ['id' => 2, 'name' => 'География', 'type' => 'select'],
            ['id' => 3, 'name' => 'Кислинка', 'type' => 'select'],
            ['id' => 4, 'name' => 'Способ обработки', 'type' => 'select'],
            ['id' => 5, 'name' => 'Особые', 'type' => 'select'],
            ['id' => 6, 'name' => 'Вид кофе', 'type' => 'select'],
            ['id' => 7, 'name' => 'По способу готовки', 'type' => 'select'],
            // Для "Чай и кофейные напитки"
            ['id' => 8, 'name' => 'Тип чая/напитка', 'type' => 'select'],
            // Для "Продукция для вендинга"
            ['id' => 9, 'name' => 'Тип продукции', 'type' => 'select'],
            // Для "Здоровое питание"
            ['id' => 10, 'name' => 'Тип продукта', 'type' => 'select'],
        ];
        $this->table('attributes')->insert($data)->save();
    }
}
