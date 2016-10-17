<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160915024930 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE Rate (id INT AUTO_INCREMENT NOT NULL, price_id INT DEFAULT NULL, option_id INT DEFAULT NULL, deleted_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7FDE9007D614C7E7 (price_id), INDEX IDX_7FDE9007A7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE `Option` (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, qty INT DEFAULT NULL, duration INT DEFAULT NULL, deleted_time DATETIME DEFAULT NULL, INDEX IDX_5D2A0586F44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Price (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Package (id INT AUTO_INCREMENT NOT NULL, performance_id INT DEFAULT NULL, service_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, deleted_time DATETIME DEFAULT NULL, INDEX IDX_11D55E09B91ADEEE (performance_id), INDEX IDX_11D55E09ED5CA9E6 (service_id), INDEX IDX_11D55E09CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Rate ADD CONSTRAINT FK_7FDE9007D614C7E7 FOREIGN KEY (price_id) REFERENCES Price (id)");
        $this->addSql("ALTER TABLE Rate ADD CONSTRAINT FK_7FDE9007A7C41D6F FOREIGN KEY (option_id) REFERENCES `Option` (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE `Option` ADD CONSTRAINT FK_5D2A0586F44CABFF FOREIGN KEY (package_id) REFERENCES Package (id) ON DELETE RESTRICT");
        $this->addSql("ALTER TABLE Package ADD CONSTRAINT FK_11D55E09B91ADEEE FOREIGN KEY (performance_id) REFERENCES Performance (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE Package ADD CONSTRAINT FK_11D55E09ED5CA9E6 FOREIGN KEY (service_id) REFERENCES Service (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE Package ADD CONSTRAINT FK_11D55E09CCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE Performance ADD is_visible TINYINT(1) DEFAULT '1' NOT NULL, ADD deleted_time DATETIME DEFAULT NULL");
        $this->addSql("ALTER TABLE RefCountry ADD ref_currencies_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE RefCountry ADD CONSTRAINT FK_5FB97C50876E7AE4 FOREIGN KEY (ref_currencies_id) REFERENCES RefCurrency (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_5FB97C50876E7AE4 ON RefCountry (ref_currencies_id)");
        $this->addSql("DROP INDEX UNIQ_2E20A34E2B36786B ON Service");
        $this->addSql("ALTER TABLE Service ADD profile_id INT DEFAULT NULL, ADD is_visible TINYINT(1) DEFAULT '1' NOT NULL, ADD deleted_time DATETIME DEFAULT NULL, DROP performance_id, DROP price, DROP currency_id, DROP deposit_value, DROP deposit_type, DROP payment_terms, DROP comments");
        $this->addSql("ALTER TABLE Service ADD CONSTRAINT FK_2E20A34ECCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id)");
        $this->addSql("CREATE INDEX IDX_2E20A34ECCFA12B8 ON Service (profile_id)");

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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE `RefCountry` SET ref_currencies_id = NULL");
        $this->addSql("DELETE FROM `RefCurrency` WHERE iso_code IN ('EUR','GBP','USD')");

        /*Service*/
        $this->addSql('ALTER TABLE Service DROP FOREIGN KEY FK_2E20A34ECCFA12B8');
        $this->addSql("ALTER TABLE Service ADD comments VARCHAR(256) NOT NULL");
        $this->addSql("ALTER TABLE Service ADD payment_terms VARCHAR(256) NOT NULL");
        $this->addSql("ALTER TABLE Service ADD deposit_type VARCHAR(32) NOT NULL");
        $this->addSql("ALTER TABLE Service ADD deposit_value DOUBLE PRECISION NOT NULL");
        $this->addSql("ALTER TABLE Service ADD currency_id INT NOT NULL");
        $this->addSql("ALTER TABLE Service ADD price DOUBLE PRECISION NOT NULL");
        $this->addSql("ALTER TABLE Service ADD performance_id INT NOT NULL");
        $this->addSql("ALTER TABLE Service DROP deleted_time");
        $this->addSql("ALTER TABLE Service DROP is_visible");
        $this->addSql("ALTER TABLE Service DROP profile_id");
        /*Service*/

        $this->addSql('CREATE UNIQUE INDEX UNIQ_2E20A34E2B36786B ON Service (title)');
        $this->addSql('ALTER TABLE RefCountry DROP FOREIGN KEY FK_5FB97C50876E7AE4');
        $this->addSql("ALTER TABLE RefCountry DROP ref_currencies_id");
        $this->addSql("ALTER TABLE Performance DROP is_visible");

        $this->addSql('ALTER TABLE Package DROP FOREIGN KEY FK_11D55E09CCFA12B8');
        $this->addSql('ALTER TABLE Package DROP FOREIGN KEY FK_11D55E09ED5CA9E6');
        $this->addSql('ALTER TABLE Package DROP FOREIGN KEY FK_11D55E09B91ADEEE');
        $this->addSql('ALTER TABLE `Option` DROP FOREIGN KEY FK_5D2A0586F44CABFF');
        $this->addSql('ALTER TABLE Rate DROP FOREIGN KEY FK_7FDE9007A7C41D6F');
        $this->addSql('ALTER TABLE Rate DROP FOREIGN KEY FK_7FDE9007D614C7E7');

        $this->addSql('DROP TABLE Package');
        $this->addSql('DROP TABLE Price');
        $this->addSql('DROP TABLE `Option`');
        $this->addSql('DROP TABLE Rate');
    }
}