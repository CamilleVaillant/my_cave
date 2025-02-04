<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204152128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cave (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cave_wine (cave_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_852C917C7F05B85 (cave_id), INDEX IDX_852C917C28A2BD76 (wine_id), PRIMARY KEY(cave_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cepage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cepage_wine (cepage_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_A2BEE2FD8AC6BB8A (cepage_id), INDEX IDX_A2BEE2FD28A2BD76 (wine_id), PRIMARY KEY(cepage_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F62F176F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, body VARCHAR(255) NOT NULL, INDEX IDX_560C646898260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cave_wine ADD CONSTRAINT FK_852C917C7F05B85 FOREIGN KEY (cave_id) REFERENCES cave (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cave_wine ADD CONSTRAINT FK_852C917C28A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cepage_wine ADD CONSTRAINT FK_A2BEE2FD8AC6BB8A FOREIGN KEY (cepage_id) REFERENCES cepage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cepage_wine ADD CONSTRAINT FK_A2BEE2FD28A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cave_wine DROP FOREIGN KEY FK_852C917C7F05B85');
        $this->addSql('ALTER TABLE cave_wine DROP FOREIGN KEY FK_852C917C28A2BD76');
        $this->addSql('ALTER TABLE cepage_wine DROP FOREIGN KEY FK_A2BEE2FD8AC6BB8A');
        $this->addSql('ALTER TABLE cepage_wine DROP FOREIGN KEY FK_A2BEE2FD28A2BD76');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176F92F3E70');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646898260155');
        $this->addSql('DROP TABLE cave');
        $this->addSql('DROP TABLE cave_wine');
        $this->addSql('DROP TABLE cepage');
        $this->addSql('DROP TABLE cepage_wine');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE wine');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
