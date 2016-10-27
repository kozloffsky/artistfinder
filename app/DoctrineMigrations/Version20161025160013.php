<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161025160013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE DocumentTechnicalRequirement (id INT AUTO_INCREMENT NOT NULL, technical_requirement_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, size INT DEFAULT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_DF8BA583587756CD (technical_requirement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE TechnicalRequirement (id INT AUTO_INCREMENT NOT NULL, artist_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_4C92ABA8B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE DocumentTechnicalRequirement ADD CONSTRAINT FK_DF8BA583587756CD FOREIGN KEY (technical_requirement_id) REFERENCES TechnicalRequirement (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE TechnicalRequirement ADD CONSTRAINT FK_4C92ABA8B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TechnicalRequirement DROP FOREIGN KEY FK_4C92ABA8B7970CF8');
        $this->addSql('ALTER TABLE DocumentTechnicalRequirement DROP FOREIGN KEY FK_DF8BA583587756CD');
        $this->addSql('DROP TABLE TechnicalRequirement');
        $this->addSql('DROP TABLE DocumentTechnicalRequirement');
    }
}
