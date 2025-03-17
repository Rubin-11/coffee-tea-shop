<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Эспрессо',
                'price' => 150.00
            ]
        ];
        $this->table('products')->insert($data)->save();
    }
}
