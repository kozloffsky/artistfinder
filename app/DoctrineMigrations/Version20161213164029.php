<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161213164029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventOffer ADD artist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975AB7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_E5A4975AB7970CF8 ON EventOffer (artist_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975AB7970CF8');
        $this->addSql('DROP INDEX IDX_E5A4975AB7970CF8 ON EventOffer');
        $this->addSql('ALTER TABLE EventOffer DROP artist_id');
    }
}
