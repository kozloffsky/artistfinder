<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161213173235 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RequestQuotation ADD artist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE RequestQuotation ADD CONSTRAINT FK_961D122B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_961D122B7970CF8 ON RequestQuotation (artist_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RequestQuotation DROP FOREIGN KEY FK_961D122B7970CF8');
        $this->addSql('DROP INDEX IDX_961D122B7970CF8 ON RequestQuotation');
        $this->addSql('ALTER TABLE RequestQuotation DROP artist_id');
    }
}
