<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515005458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Удалил колонку price у таблицы cart';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP price');
        $this->addSql('ALTER TABLE products_cart CHANGE count count INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE products_cart CHANGE count count INT DEFAULT 0 NOT NULL');
    }
}
