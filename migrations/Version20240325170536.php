<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325170536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gastos (id INT AUTO_INCREMENT NOT NULL, id_proveedor_id INT NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, precio NUMERIC(38, 0) DEFAULT NULL, fecha VARCHAR(255) DEFAULT NULL, INDEX IDX_17A58ACE8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gastos ADD CONSTRAINT FK_17A58ACE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gastos DROP FOREIGN KEY FK_17A58ACE8F12801');
        $this->addSql('DROP TABLE gastos');
    }
}
