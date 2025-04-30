<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CategoriesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE categories RESTART IDENTITY CASCADE');
        $data = [
            ['id' => 1, 'name' => 'Свежеобжаренный кофе', 'slug' => 'svezheobzharenniy-kofe'],
            ['id' => 2, 'name' => 'Чай и кофейные напитки', 'slug' => 'chay-i-kofeynye-napitki'],
            ['id' => 3, 'name' => 'Продукция для вендинга', 'slug' => 'produktsiya-dlya-vendinga'],
            ['id' => 4, 'name' => 'Здоровое питание', 'slug' => 'zdorovoe-pitanie'],
        ];
        $this->table('categories')->insert($data)->save();
    }
}
