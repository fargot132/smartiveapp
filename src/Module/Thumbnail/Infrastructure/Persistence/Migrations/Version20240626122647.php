<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240626122647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add thumbnail table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE thumbnail (id INT AUTO_INCREMENT NOT NULL, destination VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, image_path_value VARCHAR(4096) NOT NULL, thumbnail_path_value VARCHAR(4096) NOT NULL, width_value INT NOT NULL, height_value INT NOT NULL, error_message_value VARCHAR(4096) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE thumbnail');
    }
}
