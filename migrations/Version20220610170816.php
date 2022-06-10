<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610170816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, reservations_at DATE NOT NULL, reservations_max_at DATE DEFAULT NULL, reservations_long_at DATE DEFAULT NULL, reservations_long_max_at DATE DEFAULT NULL, reservations_remove TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations_user (reservations_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E3A7B3B8D9A7F869 (reservations_id), INDEX IDX_E3A7B3B8A76ED395 (user_id), PRIMARY KEY(reservations_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations_user ADD CONSTRAINT FK_E3A7B3B8D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations_user ADD CONSTRAINT FK_E3A7B3B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations_user DROP FOREIGN KEY FK_E3A7B3B8D9A7F869');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reservations_user');
    }
}
