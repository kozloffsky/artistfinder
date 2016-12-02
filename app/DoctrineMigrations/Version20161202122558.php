<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161202122558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RefCity ADD place_id LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventOffer CHANGE details_accepted details_accepted TINYINT(1) DEFAULT NULL, CHANGE acts_extras_accepted acts_extras_accepted TINYINT(1) DEFAULT NULL, CHANGE timing_accepted timing_accepted TINYINT(1) DEFAULT NULL, CHANGE technical_requirements_accepted technical_requirements_accepted TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventOffer CHANGE details_accepted details_accepted TINYINT(1) NOT NULL, CHANGE acts_extras_accepted acts_extras_accepted TINYINT(1) NOT NULL, CHANGE timing_accepted timing_accepted TINYINT(1) NOT NULL, CHANGE technical_requirements_accepted technical_requirements_accepted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE RefCity DROP place_id');
    }
}
