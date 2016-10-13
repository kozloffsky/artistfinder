<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160921030439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE RefCountry DROP FOREIGN KEY FK_5FB97C50876E7AE4");
        $this->addSql("DROP INDEX IDX_5FB97C50876E7AE4 ON RefCountry");
        $this->addSql("ALTER TABLE RefCountry CHANGE ref_currencies_id ref_currency_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE RefCountry ADD CONSTRAINT FK_5FB97C50C22D79FA FOREIGN KEY (ref_currency_id) REFERENCES RefCurrency (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_5FB97C50C22D79FA ON RefCountry (ref_currency_id)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
