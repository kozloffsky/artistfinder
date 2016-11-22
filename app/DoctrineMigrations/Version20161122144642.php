<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122144642 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE EventArtist (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, INDEX IDX_4B4A41D671F7E88B (event_id), INDEX IDX_4B4A41D6B7970CF8 (artist_id), UNIQUE INDEX uniq_event_id_artist_id (event_id, artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE EventArtist ADD CONSTRAINT FK_4B4A41D671F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE EventArtist ADD CONSTRAINT FK_4B4A41D6B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE EventArtist');
    }
}
