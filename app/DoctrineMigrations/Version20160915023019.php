<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160915023019 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE PaymentSetting (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, billing_address VARCHAR(512) NOT NULL, account_name VARCHAR(512) NOT NULL, account_number VARCHAR(32) DEFAULT NULL, iban VARCHAR(32) NOT NULL, bank_name VARCHAR(128) NOT NULL, swift_code VARCHAR(11) NOT NULL, vat_number VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_41A685C9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE PaymentSetting ADD CONSTRAINT FK_41A685C9A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)");
        $this->addSql("ALTER TABLE Artist ADD work_abroad TINYINT(1) DEFAULT '0' NOT NULL");
        $this->addSql("ALTER TABLE User ADD postcode VARCHAR(32) NOT NULL, DROP migrate");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("ALTER TABLE User ADD migrate INT(11) DEFAULT 0");
        $this->addSql('ALTER TABLE User DROP postcode');
        $this->addSql('ALTER TABLE Artist DROP work_abroad');
        $this->addSql('ALTER TABLE PaymentSetting DROP FOREIGN KEY FK_41A685C9A76ED395');
        $this->addSql('DROP TABLE PaymentSetting');
    }
}
