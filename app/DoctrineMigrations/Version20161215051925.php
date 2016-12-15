<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161215051925 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE OrderItem ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE OrderItem ADD CONSTRAINT FK_33E85E198D9F6D38 FOREIGN KEY (order_id) REFERENCES `Order` (id)');
        $this->addSql('CREATE INDEX IDX_33E85E198D9F6D38 ON OrderItem (order_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE OrderItem DROP FOREIGN KEY FK_33E85E198D9F6D38');
        $this->addSql('DROP INDEX IDX_33E85E198D9F6D38 ON OrderItem');
        $this->addSql('ALTER TABLE OrderItem DROP order_id');
    }
}
