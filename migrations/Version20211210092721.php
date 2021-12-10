<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210092721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command ADD retrait_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD47EF8457A FOREIGN KEY (retrait_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD47EF8457A ON command (retrait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD47EF8457A');
        $this->addSql('DROP INDEX IDX_8ECAEAD47EF8457A ON command');
        $this->addSql('ALTER TABLE command DROP retrait_id');
    }
}
