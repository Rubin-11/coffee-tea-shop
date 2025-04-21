<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserAddressesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE user_addresses RESTART IDENTITY CASCADE');
        $data = [
            [
                'id' => 1,
                'user_id' => 1,
                'country' => 'Россия',
                'city' => 'Москва',
                'street' => 'ул. Ленина, д. 1',
                'flat' => '12',
                'postal_code' => '101000',
                'is_primary' => true,
                'delivery_notes' => 'Домофон 1234',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'country' => 'Россия',
                'city' => 'Санкт-Петербург',
                'street' => 'Невский пр., д. 10',
                'flat' => '45',
                'postal_code' => '190000',
                'is_primary' => false,
                'delivery_notes' => 'Оставить у консьержа',
            ],
        ];
        $this->table('user_addresses')->insert($data)->save();
    }
}
