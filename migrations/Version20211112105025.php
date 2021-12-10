<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112105025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop_user (shop_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4C6130324D16C4DD (shop_id), INDEX IDX_4C613032A76ED395 (user_id), PRIMARY KEY(shop_id, user_id)) ');
        $this->addSql('ALTER TABLE shop_user ADD CONSTRAINT FK_4C6130324D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_user ADD CONSTRAINT FK_4C613032A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shop_user');
    }
}
