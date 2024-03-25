<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325171049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, id_persona_id INT DEFAULT NULL, INDEX IDX_51E5B69B50720D6E (id_persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69B50720D6E FOREIGN KEY (id_persona_id) REFERENCES gastos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69B50720D6E');
        $this->addSql('DROP TABLE persona');
    }
}
