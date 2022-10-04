<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004083051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE people_id (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE people_id_people_id (people_id_id INT NOT NULL, PRIMARY KEY(people_id_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prof (id INT AUTO_INCREMENT NOT NULL, voyagers_id INT DEFAULT NULL, prof_country VARCHAR(25) NOT NULL, INDEX IDX_5BBA70BB680DEF77 (voyagers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE people_id_people_id ADD CONSTRAINT FK_201E4A55B427E417 FOREIGN KEY (people_id_id) REFERENCES people_id (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prof ADD CONSTRAINT FK_5BBA70BB680DEF77 FOREIGN KEY (voyagers_id) REFERENCES prof (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE people_id_people_id DROP FOREIGN KEY FK_201E4A55B427E417');
        $this->addSql('ALTER TABLE prof DROP FOREIGN KEY FK_5BBA70BB680DEF77');
        $this->addSql('DROP TABLE people_id');
        $this->addSql('DROP TABLE people_id_people_id');
        $this->addSql('DROP TABLE prof');
    }
}
