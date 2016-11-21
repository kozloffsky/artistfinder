<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161120142319 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Feedback (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, rating INT DEFAULT NULL, feedback LONGTEXT DEFAULT NULL, INDEX IDX_2B5F260E71F7E88B (event_id), INDEX IDX_2B5F260EB7970CF8 (artist_id), UNIQUE INDEX uniq_event_id_artist_id (event_id, artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Feedback ADD CONSTRAINT FK_2B5F260E71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Feedback ADD CONSTRAINT FK_2B5F260EB7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Feedback');
    }
}
