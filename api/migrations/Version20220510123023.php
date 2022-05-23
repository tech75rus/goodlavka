<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510123023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создал таблицу products_cart связь с cart(один к одному)';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_cart (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, price NUMERIC(9, 2) DEFAULT NULL, INDEX IDX_87B446BD1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_cart ADD CONSTRAINT FK_87B446BD1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE products_cart');
    }
}
