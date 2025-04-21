<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AttributeValuesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE attribute_values RESTART IDENTITY CASCADE');
        $data = [
            // Степень обжарки кофе (attribute_id = 1)
            ['id' => 1, 'attribute_id' => 1, 'value' => '1'],
            ['id' => 2, 'attribute_id' => 1, 'value' => '2'],
            ['id' => 3, 'attribute_id' => 1, 'value' => '3'],
            ['id' => 4, 'attribute_id' => 1, 'value' => '4'],
            ['id' => 5, 'attribute_id' => 1, 'value' => '5'],
            // География (attribute_id = 2)
            ['id' => 6, 'attribute_id' => 2, 'value' => 'Африка'],
            ['id' => 7, 'attribute_id' => 2, 'value' => 'Йемен'],
            ['id' => 8, 'attribute_id' => 2, 'value' => 'Уганда'],
            ['id' => 9, 'attribute_id' => 2, 'value' => 'Эфиопия'],
            ['id' => 10, 'attribute_id' => 2, 'value' => 'Азия'],
            ['id' => 11, 'attribute_id' => 2, 'value' => 'Центральная Америка'],
            ['id' => 12, 'attribute_id' => 2, 'value' => 'Латинская Америка'],
            // Кислинка (attribute_id = 3)
            ['id' => 13, 'attribute_id' => 3, 'value' => 'Низкая'],
            ['id' => 14, 'attribute_id' => 3, 'value' => 'Средняя'],
            ['id' => 15, 'attribute_id' => 3, 'value' => 'Высокая'],
            // Способ обработки (attribute_id = 4)
            ['id' => 16, 'attribute_id' => 4, 'value' => 'Сухая'],
            ['id' => 17, 'attribute_id' => 4, 'value' => 'Мытая'],
            ['id' => 18, 'attribute_id' => 4, 'value' => 'Прочие'],
            // Особые (attribute_id = 5)
            ['id' => 19, 'attribute_id' => 5, 'value' => 'Популярное'],
            ['id' => 20, 'attribute_id' => 5, 'value' => 'Новый урожай'],
            ['id' => 21, 'attribute_id' => 5, 'value' => 'Ваш выбор'],
            ['id' => 22, 'attribute_id' => 5, 'value' => 'Микролот'],
            ['id' => 23, 'attribute_id' => 5, 'value' => 'Сорт недели'],
            ['id' => 24, 'attribute_id' => 5, 'value' => 'Скидки'],
            ['id' => 25, 'attribute_id' => 5, 'value' => 'Новинка'],
            // Вид кофе (attribute_id = 6)
            ['id' => 26, 'attribute_id' => 6, 'value' => 'Арабика'],
            ['id' => 27, 'attribute_id' => 6, 'value' => 'Робуста'],
            ['id' => 28, 'attribute_id' => 6, 'value' => 'Смесь арабик'],
            ['id' => 29, 'attribute_id' => 6, 'value' => 'Смесь арабика/робуста'],
            // По способу готовки (attribute_id = 7)
            ['id' => 30, 'attribute_id' => 7, 'value' => 'Турка'],
            ['id' => 31, 'attribute_id' => 7, 'value' => 'Френч-пресс'],
            ['id' => 32, 'attribute_id' => 7, 'value' => 'Мока'],
            ['id' => 33, 'attribute_id' => 7, 'value' => 'Экспрессо'],
            ['id' => 34, 'attribute_id' => 7, 'value' => 'Воронка'],
            ['id' => 35, 'attribute_id' => 7, 'value' => 'Аэропресс'],
            ['id' => 36, 'attribute_id' => 7, 'value' => 'Чашка'],
            ['id' => 37, 'attribute_id' => 7, 'value' => 'Автомат'],
            // Тип чая/напитка (attribute_id = 8)
            ['id' => 38, 'attribute_id' => 8, 'value' => 'Черный чай'],
            ['id' => 39, 'attribute_id' => 8, 'value' => 'Зеленый чай'],
            ['id' => 40, 'attribute_id' => 8, 'value' => 'Молочный улун'],
            ['id' => 41, 'attribute_id' => 8, 'value' => 'Травяной чай'],
            ['id' => 42, 'attribute_id' => 8, 'value' => 'Матча'],
            ['id' => 43, 'attribute_id' => 8, 'value' => 'Пуэр'],
            ['id' => 44, 'attribute_id' => 8, 'value' => 'Кофейные напитки'],
            // Тип продукции (attribute_id = 9)
            ['id' => 45, 'attribute_id' => 9, 'value' => 'Гранулированный кофе'],
            ['id' => 46, 'attribute_id' => 9, 'value' => 'Гранулированный цикорий'],
            ['id' => 47, 'attribute_id' => 9, 'value' => 'Зерновой кофе'],
            ['id' => 48, 'attribute_id' => 9, 'value' => 'Гранулированный какао'],
            ['id' => 49, 'attribute_id' => 9, 'value' => 'Гранулированные кофейные напитки'],
            ['id' => 50, 'attribute_id' => 9, 'value' => 'Кофе порошкообразный'],
            ['id' => 51, 'attribute_id' => 9, 'value' => 'Сухое молоко гранулированное'],
            // Тип продукта (attribute_id = 10)
            ['id' => 52, 'attribute_id' => 10, 'value' => 'Цикорий и корень цикория'],
            ['id' => 53, 'attribute_id' => 10, 'value' => 'Ячменные напитки'],
            ['id' => 54, 'attribute_id' => 10, 'value' => 'Напитки для здоровья'],
            ['id' => 55, 'attribute_id' => 10, 'value' => 'Протеиновые смеси'],
            ['id' => 56, 'attribute_id' => 10, 'value' => 'Толокняные каши'],
        ];
        $this->table('attribute_values')->insert($data)->save();
    }
}
