<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325162034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE citas (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, INDEX IDX_B88CF8E57BF9CE86 (id_cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE citas ADD CONSTRAINT FK_B88CF8E57BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citas DROP FOREIGN KEY FK_B88CF8E57BF9CE86');
        $this->addSql('DROP TABLE citas');
    }
}
