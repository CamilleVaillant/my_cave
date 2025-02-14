<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213083906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wine_cepage (wine_id INT NOT NULL, cepage_id INT NOT NULL, INDEX IDX_A2A7586428A2BD76 (wine_id), INDEX IDX_A2A758648AC6BB8A (cepage_id), PRIMARY KEY(wine_id, cepage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wine_cepage ADD CONSTRAINT FK_A2A7586428A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wine_cepage ADD CONSTRAINT FK_A2A758648AC6BB8A FOREIGN KEY (cepage_id) REFERENCES cepage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cepage_wine DROP FOREIGN KEY FK_A2BEE2FD28A2BD76');
        $this->addSql('ALTER TABLE cepage_wine DROP FOREIGN KEY FK_A2BEE2FD8AC6BB8A');
        $this->addSql('DROP TABLE cepage_wine');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cepage_wine (cepage_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_A2BEE2FD8AC6BB8A (cepage_id), INDEX IDX_A2BEE2FD28A2BD76 (wine_id), PRIMARY KEY(cepage_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cepage_wine ADD CONSTRAINT FK_A2BEE2FD28A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cepage_wine ADD CONSTRAINT FK_A2BEE2FD8AC6BB8A FOREIGN KEY (cepage_id) REFERENCES cepage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wine_cepage DROP FOREIGN KEY FK_A2A7586428A2BD76');
        $this->addSql('ALTER TABLE wine_cepage DROP FOREIGN KEY FK_A2A758648AC6BB8A');
        $this->addSql('DROP TABLE wine_cepage');
    }
}
