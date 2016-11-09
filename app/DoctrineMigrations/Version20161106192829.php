<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161106192829 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("ALTER TABLE Performance ADD is_quotation TINYINT(1) DEFAULT '0' NOT NULL");
        $this->addSql("ALTER TABLE Service ADD is_quotation TINYINT(1) DEFAULT '0' NOT NULL");

        $this->addSql("ALTER TABLE RequestQuotation DROP INDEX UNIQ_961D12271F7E88B, ADD INDEX IDX_961D12271F7E88B (event_id)");
        $this->addSql("ALTER TABLE RequestQuotation ADD is_outdated TINYINT(1) DEFAULT '0' NOT NULL");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Performance DROP is_quotation');
        $this->addSql('ALTER TABLE Service DROP is_quotation');

        $this->addSql("DROP INDEX IDX_961D12271F7E88B ON RequestQuotation");
        $this->addSql('CREATE UNIQUE INDEX UNIQ_961D12271F7E88B ON RequestQuotation (event_id)');
    }
}
