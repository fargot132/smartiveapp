<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626133939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change thumbnail_path_value and error_message_value to nullable in thumbnail table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE thumbnail CHANGE thumbnail_path_value thumbnail_path_value VARCHAR(4096) DEFAULT NULL, CHANGE error_message_value error_message_value VARCHAR(4096) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE thumbnail CHANGE thumbnail_path_value thumbnail_path_value VARCHAR(4096) NOT NULL, CHANGE error_message_value error_message_value VARCHAR(4096) NOT NULL');
    }
}
