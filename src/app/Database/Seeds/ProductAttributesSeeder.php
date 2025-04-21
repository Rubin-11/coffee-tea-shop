<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ProductAttributesSeeder extends AbstractSeed
{
    public function run(): void
    {
        // Обновленные связи product_id 1-40 с соответствующими атрибутами и значениями для каждой категории
        $data = [
            // Продукты 1-10: кофе (атрибуты 1-7)
            ['product_id' => 1, 'attribute_value_id' => 3],
            ['product_id' => 2, 'attribute_value_id' => 7],
            ['product_id' => 3, 'attribute_value_id' => 15],
            ['product_id' => 4, 'attribute_value_id' => 16],
            ['product_id' => 5, 'attribute_value_id' => 19],
            ['product_id' => 6, 'attribute_value_id' => 27],
            ['product_id' => 7, 'attribute_value_id' => 31],
            ['product_id' => 8, 'attribute_value_id' => 5],
            ['product_id' => 9, 'attribute_value_id' => 10],
            ['product_id' => 10, 'attribute_value_id' => 13],
            // Продукты 11-20: чай и кофейные напитки (атрибут 8)
            ['product_id' => 11, 'attribute_value_id' => 38],
            ['product_id' => 12, 'attribute_value_id' => 39],
            ['product_id' => 13, 'attribute_value_id' => 40],
            ['product_id' => 14, 'attribute_value_id' => 43],
            ['product_id' => 15, 'attribute_value_id' => 42],
            ['product_id' => 16, 'attribute_value_id' => 41],
            ['product_id' => 17, 'attribute_value_id' => 44],
            ['product_id' => 18, 'attribute_value_id' => 38],
            ['product_id' => 19, 'attribute_value_id' => 39],
            ['product_id' => 20, 'attribute_value_id' => 40],
            // Продукты 21-30: вендинг (атрибут 9)
            ['product_id' => 21, 'attribute_value_id' => 45],
            ['product_id' => 22, 'attribute_value_id' => 46],
            ['product_id' => 23, 'attribute_value_id' => 47],
            ['product_id' => 24, 'attribute_value_id' => 48],
            ['product_id' => 25, 'attribute_value_id' => 49],
            ['product_id' => 26, 'attribute_value_id' => 50],
            ['product_id' => 27, 'attribute_value_id' => 51],
            ['product_id' => 28, 'attribute_value_id' => 45],
            ['product_id' => 29, 'attribute_value_id' => 46],
            ['product_id' => 30, 'attribute_value_id' => 47],
            // Продукты 31-40: здоровое питание (атрибут 10)
            ['product_id' => 31, 'attribute_value_id' => 52],
            ['product_id' => 32, 'attribute_value_id' => 53],
            ['product_id' => 33, 'attribute_value_id' => 54],
            ['product_id' => 34, 'attribute_value_id' => 55],
            ['product_id' => 35, 'attribute_value_id' => 56],
            ['product_id' => 36, 'attribute_value_id' => 52],
            ['product_id' => 37, 'attribute_value_id' => 53],
            ['product_id' => 38, 'attribute_value_id' => 54],
            ['product_id' => 39, 'attribute_value_id' => 55],
            ['product_id' => 40, 'attribute_value_id' => 56],
        ];
        $this->execute('TRUNCATE TABLE product_attributes RESTART IDENTITY CASCADE');
        $this->table('product_attributes')->insert($data)->save();
    }
}
