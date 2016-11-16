<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161102162958 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE ServiceRequestQuotation (id INT AUTO_INCREMENT NOT NULL, request_quotation_id INT DEFAULT NULL, service_id INT DEFAULT NULL, is_selected TINYINT(1) DEFAULT '0' NOT NULL, INDEX IDX_545E4AB2AFC017B8 (request_quotation_id), INDEX IDX_545E4AB2ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE DocumentRequestQuotation (id INT AUTO_INCREMENT NOT NULL, request_quotation_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_83A0C96AAFC017B8 (request_quotation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE RequestQuotation (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, status TINYINT(1) DEFAULT '0' NOT NULL, UNIQUE INDEX UNIQ_961D12271F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE PerformanceRequestQuotation (id INT AUTO_INCREMENT NOT NULL, request_quotation_id INT DEFAULT NULL, performance_id INT DEFAULT NULL, is_selected TINYINT(1) DEFAULT '0' NOT NULL, INDEX IDX_6E815E08AFC017B8 (request_quotation_id), INDEX IDX_6E815E08B91ADEEE (performance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE PaymentTermRequestQuotation (id INT AUTO_INCREMENT NOT NULL, request_quotation_id INT DEFAULT NULL, guaranteed_deposit_percent SMALLINT DEFAULT 0 NOT NULL, balance_percent SMALLINT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_DBB09A54AFC017B8 (request_quotation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE ServiceRequestQuotation ADD CONSTRAINT FK_545E4AB2AFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE ServiceRequestQuotation ADD CONSTRAINT FK_545E4AB2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES Service (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE DocumentRequestQuotation ADD CONSTRAINT FK_83A0C96AAFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE RequestQuotation ADD CONSTRAINT FK_961D12271F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE PerformanceRequestQuotation ADD CONSTRAINT FK_6E815E08AFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE PerformanceRequestQuotation ADD CONSTRAINT FK_6E815E08B91ADEEE FOREIGN KEY (performance_id) REFERENCES Performance (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE PaymentTermRequestQuotation ADD CONSTRAINT FK_DBB09A54AFC017B8 FOREIGN KEY (request_quotation_id) REFERENCES RequestQuotation (id) ON DELETE RESTRICT");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PaymentTermRequestQuotation DROP FOREIGN KEY FK_DBB09A54AFC017B8');
        $this->addSql('ALTER TABLE PerformanceRequestQuotation DROP FOREIGN KEY FK_6E815E08B91ADEEE');
        $this->addSql('ALTER TABLE PerformanceRequestQuotation DROP FOREIGN KEY FK_6E815E08AFC017B8');
        $this->addSql('ALTER TABLE RequestQuotation DROP FOREIGN KEY FK_961D12271F7E88B');
        $this->addSql('ALTER TABLE DocumentRequestQuotation DROP FOREIGN KEY FK_83A0C96AAFC017B8');
        $this->addSql('ALTER TABLE ServiceRequestQuotation DROP FOREIGN KEY FK_545E4AB2ED5CA9E6');
        $this->addSql('ALTER TABLE ServiceRequestQuotation DROP FOREIGN KEY FK_545E4AB2AFC017B8');

        $this->addSql("DROP TABLE PaymentTermRequestQuotation");
        $this->addSql("DROP TABLE PerformanceRequestQuotation");
        $this->addSql("DROP TABLE RequestQuotation");
        $this->addSql("DROP TABLE DocumentRequestQuotation");
        $this->addSql("DROP TABLE ServiceRequestQuotation");
    }
}
