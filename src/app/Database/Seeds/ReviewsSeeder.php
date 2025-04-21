<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ReviewsSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            // Примеры отзывов для первых 40 продуктов, только от обычных пользователей (user_id 2-10)
            ['id' => 1, 'user_id' => 2, 'product_id' => 1, 'rating' => 4, 'comment' => 'Вкусный кофе, рекомендую!'],
            ['id' => 2, 'user_id' => 3, 'product_id' => 2, 'rating' => 5, 'comment' => 'Очень понравился чай!'],
            ['id' => 3, 'user_id' => 4, 'product_id' => 3, 'rating' => 4, 'comment' => 'Вендинговый кофе бодрит.'],
            ['id' => 4, 'user_id' => 5, 'product_id' => 4, 'rating' => 3, 'comment' => 'Цикорий на любителя.'],
            ['id' => 5, 'user_id' => 6, 'product_id' => 5, 'rating' => 5, 'comment' => 'Гватемала — супер!'],
            ['id' => 6, 'user_id' => 7, 'product_id' => 6, 'rating' => 4, 'comment' => 'Йемен — необычный вкус.'],
            ['id' => 7, 'user_id' => 8, 'product_id' => 7, 'rating' => 4, 'comment' => 'Уганда крепкий.'],
            ['id' => 8, 'user_id' => 9, 'product_id' => 8, 'rating' => 5, 'comment' => 'Суматра — насыщенный.'],
            ['id' => 9, 'user_id' => 10, 'product_id' => 9, 'rating' => 4, 'comment' => 'Blend вкусный.'],
            ['id' => 10, 'user_id' => 2, 'product_id' => 10, 'rating' => 5, 'comment' => 'Панама — топ!'],
            ['id' => 11, 'user_id' => 3, 'product_id' => 11, 'rating' => 5, 'comment' => 'Сенча свежий.'],
            ['id' => 12, 'user_id' => 4, 'product_id' => 12, 'rating' => 4, 'comment' => 'Ассам крепкий.'],
            ['id' => 13, 'user_id' => 5, 'product_id' => 13, 'rating' => 5, 'comment' => 'Эрл Грей ароматный.'],
            ['id' => 14, 'user_id' => 6, 'product_id' => 14, 'rating' => 3, 'comment' => 'Пуэр специфический.'],
            ['id' => 15, 'user_id' => 7, 'product_id' => 15, 'rating' => 5, 'comment' => 'Матча бодрит.'],
            ['id' => 16, 'user_id' => 8, 'product_id' => 16, 'rating' => 4, 'comment' => 'Молочный улун классный.'],
            ['id' => 17, 'user_id' => 9, 'product_id' => 17, 'rating' => 4, 'comment' => 'Травяной чай расслабляет.'],
            ['id' => 18, 'user_id' => 10, 'product_id' => 18, 'rating' => 5, 'comment' => 'Капучино вкусный.'],
            ['id' => 19, 'user_id' => 2, 'product_id' => 19, 'rating' => 5, 'comment' => 'Латте понравился.'],
            ['id' => 20, 'user_id' => 3, 'product_id' => 20, 'rating' => 4, 'comment' => 'Жасминовый чай ароматный.'],
            ['id' => 21, 'user_id' => 4, 'product_id' => 21, 'rating' => 5, 'comment' => 'Гранулированный кофе удобен.'],
            ['id' => 22, 'user_id' => 5, 'product_id' => 22, 'rating' => 4, 'comment' => 'Цикорий для вендинга.'],
            ['id' => 23, 'user_id' => 6, 'product_id' => 23, 'rating' => 5, 'comment' => 'Зерновой кофе отличный.'],
            ['id' => 24, 'user_id' => 7, 'product_id' => 24, 'rating' => 3, 'comment' => 'Какао средний.'],
            ['id' => 25, 'user_id' => 8, 'product_id' => 25, 'rating' => 4, 'comment' => 'Кофейные напитки понравились.'],
            ['id' => 26, 'user_id' => 9, 'product_id' => 26, 'rating' => 5, 'comment' => 'Порошкообразный кофе насыщенный.'],
            ['id' => 27, 'user_id' => 10, 'product_id' => 27, 'rating' => 4, 'comment' => 'Молоко хорошее.'],
            ['id' => 28, 'user_id' => 2, 'product_id' => 28, 'rating' => 5, 'comment' => 'Гранулированный чай супер.'],
            ['id' => 29, 'user_id' => 3, 'product_id' => 29, 'rating' => 4, 'comment' => 'Горячий шоколад вкусный.'],
            ['id' => 30, 'user_id' => 4, 'product_id' => 30, 'rating' => 5, 'comment' => 'Растворимый кофе отличный.'],
            ['id' => 31, 'user_id' => 5, 'product_id' => 31, 'rating' => 5, 'comment' => 'Цикорий полезный.'],
            ['id' => 32, 'user_id' => 6, 'product_id' => 32, 'rating' => 4, 'comment' => 'Ячменные напитки необычные.'],
            ['id' => 33, 'user_id' => 7, 'product_id' => 33, 'rating' => 5, 'comment' => 'Здоровые напитки — класс!'],
            ['id' => 34, 'user_id' => 8, 'product_id' => 34, 'rating' => 3, 'comment' => 'Протеиновые смеси норм.'],
            ['id' => 35, 'user_id' => 9, 'product_id' => 35, 'rating' => 5, 'comment' => 'Толокняные каши вкусные.'],
            ['id' => 36, 'user_id' => 10, 'product_id' => 36, 'rating' => 4, 'comment' => 'Батончики понравились.'],
            ['id' => 37, 'user_id' => 2, 'product_id' => 37, 'rating' => 4, 'comment' => 'Суперфуды бодрят.'],
            ['id' => 38, 'user_id' => 3, 'product_id' => 38, 'rating' => 5, 'comment' => 'Органические смеси отличные.'],
            ['id' => 39, 'user_id' => 4, 'product_id' => 39, 'rating' => 4, 'comment' => 'Безглютеновые продукты полезные.'],
            ['id' => 40, 'user_id' => 5, 'product_id' => 40, 'rating' => 5, 'comment' => 'Веганские продукты понравились.'],
        ];
        $this->execute('TRUNCATE TABLE reviews RESTART IDENTITY CASCADE');
        $this->table('reviews')->insert($data)->save();
    }
}
