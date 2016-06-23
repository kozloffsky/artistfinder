<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160623115842 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO `RefRole` VALUES (3,'ROLE_ADMIN','Admin')");

        $this->addSql('INSERT INTO `User` (`id`, `firstname`, `lastname`, `email`, `active`, `password_hash`) VALUES 
            (350, \'admin\', \'adminovich\', \'admin@admin.com\', 1, \'$2y$13$dsUus5tSMZzttIk8Ql59Oe8K5.3gUrDzYMSQTT6rS8dpKdzMYLjPO\')');

        $this->addSql("INSERT INTO `user_ref_role` VALUES (350, 3)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
