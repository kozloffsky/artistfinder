<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160704150846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Recommend (id INT AUTO_INCREMENT NOT NULL, artist_id INT DEFAULT NULL, category_id INT DEFAULT NULL, value INT NOT NULL, INDEX IDX_36094EF7B7970CF8 (artist_id), INDEX IDX_36094EF712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Recommend ADD CONSTRAINT FK_36094EF7B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
        $this->addSql('ALTER TABLE Recommend ADD CONSTRAINT FK_36094EF712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category DROP recommend');
        $this->addSql('ALTER TABLE Artist DROP recommend');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Recommend');
        $this->addSql('ALTER TABLE Artist ADD recommend INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD recommend TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
