<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table("products");
        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->create();
    }
}
