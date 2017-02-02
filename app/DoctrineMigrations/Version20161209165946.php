<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209165946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `Order` (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, client_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, status INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, payment_expiration_date DATETIME NOT NULL, deposit_amount DOUBLE PRECISION NOT NULL, deposit_ballance DOUBLE PRECISION NOT NULL, actor_details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', client_details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', performance_start_time VARCHAR(255) NOT NULL, additional_info LONGTEXT NOT NULL, technical_requirements LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', guaranteed_deposit_term INT NOT NULL, guaranteed_balance_term INT NOT NULL, details_accepted TINYINT(1) DEFAULT NULL, acts_extras_accepted TINYINT(1) DEFAULT NULL, timing_accepted TINYINT(1) DEFAULT NULL, technical_requirements_accepted TINYINT(1) DEFAULT NULL, INDEX IDX_34E8BC9C71F7E88B (event_id), INDEX IDX_34E8BC9C19EB6921 (client_id), INDEX IDX_34E8BC9CB7970CF8 (artist_id), INDEX IDX_34E8BC9C38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE OrderItem (id INT AUTO_INCREMENT NOT NULL, performance_id INT DEFAULT NULL, service_id INT DEFAULT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', total_price DOUBLE PRECISION NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_33E85E19B91ADEEE (performance_id), INDEX IDX_33E85E19ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `Order` ADD CONSTRAINT FK_34E8BC9C71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE `Order` ADD CONSTRAINT FK_34E8BC9C19EB6921 FOREIGN KEY (client_id) REFERENCES Client (id)');
        $this->addSql('ALTER TABLE `Order` ADD CONSTRAINT FK_34E8BC9CB7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
        $this->addSql('ALTER TABLE `Order` ADD CONSTRAINT FK_34E8BC9C38248176 FOREIGN KEY (currency_id) REFERENCES RefCurrency (id)');
        $this->addSql('ALTER TABLE OrderItem ADD CONSTRAINT FK_33E85E19B91ADEEE FOREIGN KEY (performance_id) REFERENCES Performance (id)');
        $this->addSql('ALTER TABLE OrderItem ADD CONSTRAINT FK_33E85E19ED5CA9E6 FOREIGN KEY (service_id) REFERENCES Service (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC8D9F6D38 FOREIGN KEY (order_id) REFERENCES `Order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_467AA3AC8D9F6D38 ON ChatRoom (order_id)');
        $this->addSql('ALTER TABLE Client CHANGE user_id user_id INT DEFAULT NULL, CHANGE client_type client_type VARCHAR(32) DEFAULT NULL, CHANGE address address VARCHAR(256) DEFAULT NULL, CHANGE city_id city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Client ADD CONSTRAINT FK_C0E80163A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0E80163A76ED395 ON Client (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC8D9F6D38');
        $this->addSql('DROP TABLE `Order`');
        $this->addSql('DROP TABLE OrderItem');
        $this->addSql('DROP INDEX UNIQ_467AA3AC8D9F6D38 ON ChatRoom');
        $this->addSql('ALTER TABLE ChatRoom CHANGE order_id order_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Client DROP FOREIGN KEY FK_C0E80163A76ED395');
        $this->addSql('DROP INDEX UNIQ_C0E80163A76ED395 ON Client');
        $this->addSql('ALTER TABLE Client CHANGE user_id user_id INT NOT NULL, CHANGE client_type client_type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, CHANGE address address VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci, CHANGE city_id city_id INT NOT NULL');
    }
}
