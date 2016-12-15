<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161215051019 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC53C674EE');
        $this->addSql('DROP INDEX UNIQ_467AA3AC53C674EE ON ChatRoom');
        $this->addSql('ALTER TABLE ChatRoom DROP offer_id');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ChatRoom ADD offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_467AA3AC53C674EE ON ChatRoom (offer_id)');
        //
    }
}
