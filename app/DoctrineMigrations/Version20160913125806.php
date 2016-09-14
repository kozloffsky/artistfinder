<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160913125806 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE PricePackage (id INT AUTO_INCREMENT NOT NULL, price_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, deleted_time DATETIME DEFAULT NULL, INDEX IDX_BD4ECA22D614C7E7 (price_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE PriceOptionRate (id INT AUTO_INCREMENT NOT NULL, price_option_id INT DEFAULT NULL, price INT DEFAULT NULL, deleted_time DATETIME DEFAULT NULL, INDEX IDX_8D7EF61524752E93 (price_option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Price (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, services_id INT DEFAULT NULL, performances_id INT DEFAULT NULL, deleted_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B090DDDCCFA12B8 (profile_id), INDEX IDX_B090DDDAEF5A6C1 (services_id), INDEX IDX_B090DDDA07A6884 (performances_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE PaymentSetting (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, billing_address VARCHAR(512) NOT NULL, account_name VARCHAR(512) NOT NULL, account_number VARCHAR(32) DEFAULT NULL, iban VARCHAR(32) NOT NULL, bank_name VARCHAR(128) NOT NULL, swift_code VARCHAR(11) NOT NULL, vat_number VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_41A685C9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE PriceOption (id INT AUTO_INCREMENT NOT NULL, price_package_id INT DEFAULT NULL, qty INT DEFAULT NULL, duration INT DEFAULT NULL, deleted_time DATETIME DEFAULT NULL, INDEX IDX_7A476EAD40C4A4FB (price_package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE PricePackage ADD CONSTRAINT FK_BD4ECA22D614C7E7 FOREIGN KEY (price_id) REFERENCES Price (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE PriceOptionRate ADD CONSTRAINT FK_8D7EF61524752E93 FOREIGN KEY (price_option_id) REFERENCES PriceOption (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE Price ADD CONSTRAINT FK_B090DDDCCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE Price ADD CONSTRAINT FK_B090DDDAEF5A6C1 FOREIGN KEY (services_id) REFERENCES Service (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE Price ADD CONSTRAINT FK_B090DDDA07A6884 FOREIGN KEY (performances_id) REFERENCES Performance (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE PaymentSetting ADD CONSTRAINT FK_41A685C9A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)");
        $this->addSql("ALTER TABLE PriceOption ADD CONSTRAINT FK_7A476EAD40C4A4FB FOREIGN KEY (price_package_id) REFERENCES PricePackage (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE Performance ADD is_visible TINYINT(1) DEFAULT '1' NOT NULL");
        $this->addSql("ALTER TABLE Artist ADD work_abroad TINYINT(1) DEFAULT '0' NOT NULL, CHANGE spotlight spotlight INT DEFAULT NULL");
        $this->addSql("ALTER TABLE User ADD postcode VARCHAR(32) NOT NULL, DROP migrate");
        $this->addSql("ALTER TABLE RefCountry ADD ref_currencies_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE RefCountry ADD CONSTRAINT FK_5FB97C50876E7AE4 FOREIGN KEY (ref_currencies_id) REFERENCES RefCurrency (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_5FB97C50876E7AE4 ON RefCountry (ref_currencies_id)");
        $this->addSql("ALTER TABLE Service ADD is_visible TINYINT(1) DEFAULT '1' NOT NULL, DROP price");

        $this->addSql("INSERT INTO `RefCurrency`(iso_code, symbol) VALUES ('EUR','€'),('GBP','£'),('USD','$')");

        $this->addSql("UPDATE `RefCountry` SET ref_currencies_id = (SELECT id from `RefCurrency` where iso_code = 'EUR') where name = 'France'");
        $this->addSql("UPDATE `RefCountry` SET ref_currencies_id = (SELECT id from `RefCurrency` where iso_code = 'EUR') where name = 'Germany'");
        $this->addSql("UPDATE `RefCountry` SET ref_currencies_id = (SELECT id from `RefCurrency` where iso_code = 'GBP') where name = 'United Kingdom'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}