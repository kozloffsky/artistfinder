<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161112184443 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO `Template` (type_id, is_active, template) VALUES (4, 1, '<!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <title>Title</title>
            </head>
            <body>
            <DIV id=\"page_1\">
                <div>
                 Services:
                 [services]
                </div>
                
                <div>
                 Performances:
                 [performances]
                </div>
                
                <div>
                 Event:
                 [event]
                </div>
                
                <div>
                 Payment term:
                 [payment_term]
                </div>
            </DIV>
            </body>
            </html>')");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE `Template` FROM WHERE type_id = 4");

    }
}
