<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511094001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'для products_cart сделал по умолчанию product_id NULL';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_cart ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products_cart ADD CONSTRAINT FK_87B446BD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87B446BD4584665A ON products_cart (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_cart DROP FOREIGN KEY FK_87B446BD4584665A');
        $this->addSql('DROP INDEX UNIQ_87B446BD4584665A ON products_cart');
        $this->addSql('ALTER TABLE products_cart DROP product_id');
    }
}
