<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE users RESTART IDENTITY CASCADE');
        $data = [
            ['id' => 1, 'email' => 'user1@example.com', 'password_hash' => password_hash('password1', PASSWORD_DEFAULT), 'is_admin'=> true],
            ['id' => 2, 'email' => 'user2@example.com', 'password_hash' => password_hash('password2', PASSWORD_DEFAULT)],
            ['id' => 3, 'email' => 'user3@example.com', 'password_hash' => password_hash('password3', PASSWORD_DEFAULT)],
            ['id' => 4, 'email' => 'user4@example.com', 'password_hash' => password_hash('password4', PASSWORD_DEFAULT)],
            ['id' => 5, 'email' => 'user5@example.com', 'password_hash' => password_hash('password5', PASSWORD_DEFAULT)],
            ['id' => 6, 'email' => 'user6@example.com', 'password_hash' => password_hash('password6', PASSWORD_DEFAULT)],
            ['id' => 7, 'email' => 'user7@example.com', 'password_hash' => password_hash('password7', PASSWORD_DEFAULT)],
            ['id' => 8, 'email' => 'user8@example.com', 'password_hash' => password_hash('password8', PASSWORD_DEFAULT)],
            ['id' => 9, 'email' => 'user9@example.com', 'password_hash' => password_hash('password9', PASSWORD_DEFAULT)],
            ['id' => 10, 'email' => 'user10@example.com', 'password_hash' => password_hash('password10', PASSWORD_DEFAULT)],
        ];
        $this->table('users')->insert($data)->save();
    }
}
