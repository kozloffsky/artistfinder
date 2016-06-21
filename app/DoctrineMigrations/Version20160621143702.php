<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160621143702 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Message DROP file_path');
        $this->addSql('ALTER TABLE MessageFile CHANGE message_id message_id INT DEFAULT NULL, CHANGE file_name file_name VARCHAR(256) NOT NULL, CHANGE file_size file_size INT DEFAULT NULL');
        $this->addSql('ALTER TABLE MessageFile ADD CONSTRAINT FK_CE6F85EF537A1329 FOREIGN KEY (message_id) REFERENCES Message (id)');
        $this->addSql('CREATE INDEX IDX_CE6F85EF537A1329 ON MessageFile (message_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Message ADD file_path VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE MessageFile DROP FOREIGN KEY FK_CE6F85EF537A1329');
        $this->addSql('DROP INDEX IDX_CE6F85EF537A1329 ON MessageFile');
        $this->addSql('ALTER TABLE MessageFile CHANGE message_id message_id INT NOT NULL, CHANGE file_name file_name INT NOT NULL, CHANGE file_size file_size INT NOT NULL');
    }
}
