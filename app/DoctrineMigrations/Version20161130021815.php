<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161130021815 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE MessageFile ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE MessageFile ADD CONSTRAINT FK_CE6F85EFEA9FDD75 FOREIGN KEY (media_id) REFERENCES Media (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE6F85EFEA9FDD75 ON MessageFile (media_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE MessageFile DROP FOREIGN KEY FK_CE6F85EFEA9FDD75');
        $this->addSql('DROP INDEX UNIQ_CE6F85EFEA9FDD75 ON MessageFile');
        $this->addSql('ALTER TABLE MessageFile DROP media_id');
    }
}
