<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621141951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calibre (id INT AUTO_INCREMENT NOT NULL, calibre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frigos (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, csv VARCHAR(255) NOT NULL, stockage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frigos_variete (frigos_id INT NOT NULL, variete_id INT NOT NULL, INDEX IDX_6767F214D732BF75 (frigos_id), INDEX IDX_6767F214620D5460 (variete_id), PRIMARY KEY(frigos_id, variete_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frigos_producteurs (frigos_id INT NOT NULL, producteurs_id INT NOT NULL, INDEX IDX_FDF97709D732BF75 (frigos_id), INDEX IDX_FDF97709E7DA2696 (producteurs_id), PRIMARY KEY(frigos_id, producteurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producteurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variete (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, telephone VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variete_calibre (variete_id INT NOT NULL, calibre_id INT NOT NULL, INDEX IDX_C1BFFF06620D5460 (variete_id), INDEX IDX_C1BFFF0658FEF8CD (calibre_id), PRIMARY KEY(variete_id, calibre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE frigos_variete ADD CONSTRAINT FK_6767F214D732BF75 FOREIGN KEY (frigos_id) REFERENCES frigos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frigos_variete ADD CONSTRAINT FK_6767F214620D5460 FOREIGN KEY (variete_id) REFERENCES variete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frigos_producteurs ADD CONSTRAINT FK_FDF97709D732BF75 FOREIGN KEY (frigos_id) REFERENCES frigos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frigos_producteurs ADD CONSTRAINT FK_FDF97709E7DA2696 FOREIGN KEY (producteurs_id) REFERENCES producteurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variete_calibre ADD CONSTRAINT FK_C1BFFF06620D5460 FOREIGN KEY (variete_id) REFERENCES variete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variete_calibre ADD CONSTRAINT FK_C1BFFF0658FEF8CD FOREIGN KEY (calibre_id) REFERENCES calibre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variete_calibre DROP FOREIGN KEY FK_C1BFFF0658FEF8CD');
        $this->addSql('ALTER TABLE frigos_variete DROP FOREIGN KEY FK_6767F214D732BF75');
        $this->addSql('ALTER TABLE frigos_producteurs DROP FOREIGN KEY FK_FDF97709D732BF75');
        $this->addSql('ALTER TABLE frigos_producteurs DROP FOREIGN KEY FK_FDF97709E7DA2696');
        $this->addSql('ALTER TABLE frigos_variete DROP FOREIGN KEY FK_6767F214620D5460');
        $this->addSql('ALTER TABLE variete_calibre DROP FOREIGN KEY FK_C1BFFF06620D5460');
        $this->addSql('DROP TABLE calibre');
        $this->addSql('DROP TABLE frigos');
        $this->addSql('DROP TABLE frigos_variete');
        $this->addSql('DROP TABLE frigos_producteurs');
        $this->addSql('DROP TABLE producteurs');
        $this->addSql('DROP TABLE variete');
        $this->addSql('DROP TABLE variete_calibre');
    }
}
