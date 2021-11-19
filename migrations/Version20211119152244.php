<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119152244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_shop (reservation_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_BA5381CAB83297E7 (reservation_id), INDEX IDX_BA5381CA4D16C4DD (shop_id), PRIMARY KEY(reservation_id, shop_id))');
        $this->addSql('ALTER TABLE reservation_shop ADD CONSTRAINT FK_BA5381CAB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_shop ADD CONSTRAINT FK_BA5381CA4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation CHANGE start_date start_date VARCHAR(255) NOT NULL, CHANGE end_date end_date VARCHAR(255) NOT NULL, CHANGE day day VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation_shop');
        $this->addSql('ALTER TABLE reservation CHANGE day day VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE start_date start_date VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE end_date end_date VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
