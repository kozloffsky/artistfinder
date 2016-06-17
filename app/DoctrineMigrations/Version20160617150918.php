<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160617150918 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO `InvoiceType` VALUES (1,1,\'sdfasf\',\'dsfasfsdf\',\'sdfdsfasdf\',\'so22345\',\'123\',\'123\',\'123\',\'123\',\'123e\',\'rffd\',\'sdfasdfds\',\'fasfsdfdsf\',\'dsfdsf\',\'2017-01-01\',\'123\',\'123\',\'2017-01-01\',\'dsafsd\',\'dsfdsfsdfasd\',12.00,12.00,1,2,1,1,123.00,123.00,123.00,123.00,20.00,123.00,0.00,0.00,\'wqwe\',NULL),(2,4,\'sdfasf\',\'dsfasfsdf\',\'sdfdsfasdf\',\'so22345\',\'123\',\'123\',\'123\',\'123\',\'123e\',\'rffd\',\'sdfasdfds\',\'fasfsdfdsf\',\'dsfdsf\',\'2017-01-01\',\'123\',\'123\',\'2017-01-01\',\'dsafsd\',\'dsfdsfsdfasd\',12.00,12.00,1,2,1,1,123.00,123.00,123.00,123.00,20.00,123.00,12.00,12.00,\'Acted company name\',\'docs/invoice/invoice_1_20160608-115906.pdf\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
