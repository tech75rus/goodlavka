<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612203042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_yookassa VARCHAR(64) NOT NULL, status VARCHAR(255) NOT NULL, price NUMERIC(7, 2) NOT NULL, at_create DATETIME NOT NULL, at_update DATETIME NOT NULL, INDEX IDX_6D28840D79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_detail (id INT AUTO_INCREMENT NOT NULL, id_payment_id INT NOT NULL, id_product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(7, 2) NOT NULL, count INT NOT NULL, INDEX IDX_B3EE405A149236C (id_payment_id), INDEX IDX_B3EE405E00EE68D (id_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment_detail ADD CONSTRAINT FK_B3EE405A149236C FOREIGN KEY (id_payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE payment_detail ADD CONSTRAINT FK_B3EE405E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_detail DROP FOREIGN KEY FK_B3EE405A149236C');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_detail');
    }
}
