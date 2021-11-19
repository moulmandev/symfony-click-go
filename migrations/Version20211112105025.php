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
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE command_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reservation_id INT NOT NULL, is_delivered TINYINT(1) NOT NULL, INDEX IDX_8ECAEAD4A76ED395 (user_id), INDEX IDX_8ECAEAD4B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE command_product (command_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_3C20574E33E1689A (command_id), INDEX IDX_3C20574E4584665A (product_id), PRIMARY KEY(command_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE shop_user');
    }
}
