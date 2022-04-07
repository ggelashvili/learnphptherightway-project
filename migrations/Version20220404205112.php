<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404205112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice_items (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(10, 2) NOT NULL, INDEX IDX_DCC4B9F82989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(10, 2) NOT NULL, invoice_number VARCHAR(255) NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_items ADD CONSTRAINT FK_DCC4B9F82989F1FD FOREIGN KEY (invoice_id) REFERENCES invoices (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_items DROP FOREIGN KEY FK_DCC4B9F82989F1FD');
        $this->addSql('DROP TABLE invoice_items');
        $this->addSql('DROP TABLE invoices');
    }
}
