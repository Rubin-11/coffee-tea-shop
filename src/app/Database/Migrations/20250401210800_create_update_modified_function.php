<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUpdateModifiedFunction extends AbstractMigration
{
    public function up(): void
    {
        // Создание функции для обновления timestamp
        $this->execute('
            CREATE OR REPLACE FUNCTION update_modified_column()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.updated_at = NOW();
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;'
        );
    }

    public function down(): void
    {
        $this->execute('DROP FUNCTION IF EXISTS update_modified_column() CASCADE;');
    }
}
