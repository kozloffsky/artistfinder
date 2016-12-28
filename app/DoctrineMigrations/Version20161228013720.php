<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161228013720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PerformanceRequestQuotation DROP FOREIGN KEY FK_6E815E08AFC017B8');
        $this->addSql('ALTER TABLE PerformanceRequestQuotation ADD CONSTRAINT FK_6E815E08AFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE RequestQuotation DROP FOREIGN KEY FK_961D12271F7E88B');
        $this->addSql('ALTER TABLE RequestQuotation ADD CONSTRAINT FK_961D12271F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PerformanceRequestQuotation DROP FOREIGN KEY FK_6E815E08AFC017B8');
        $this->addSql('ALTER TABLE PerformanceRequestQuotation ADD CONSTRAINT FK_6E815E08AFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id)');
        $this->addSql('ALTER TABLE RequestQuotation DROP FOREIGN KEY FK_961D12271F7E88B');
        $this->addSql('ALTER TABLE RequestQuotation ADD CONSTRAINT FK_961D12271F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
    }
}
