<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220155958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, id_organisation INT NOT NULL, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mobileNumber VARCHAR(255) NOT NULL, INDEX IDX_4C62E638C52047C6 (id_organisation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postalCode VARCHAR(255) NOT NULL, countryCode VARCHAR(255) NOT NULL, startup TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, id_organisation INT NOT NULL, id_category INT DEFAULT NULL, gtin VARCHAR(20) DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(7, 3) NOT NULL, stock_quantity INT NOT NULL, creation_date_time DATETIME NOT NULL, INDEX IDX_D34A04ADC52047C6 (id_organisation), INDEX IDX_D34A04AD5697F554 (id_category), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638C52047C6 FOREIGN KEY (id_organisation) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC52047C6 FOREIGN KEY (id_organisation) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5697F554 FOREIGN KEY (id_category) REFERENCES product_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638C52047C6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC52047C6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5697F554');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
    }
}
