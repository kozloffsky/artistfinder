<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615122834 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tweedegolf_logged_message (id INT AUTO_INCREMENT NOT NULL, from_field TEXT NOT NULL COMMENT \'(DC2Type:array)\', to_field LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', generated_id VARCHAR(255) NOT NULL, return_path VARCHAR(255) DEFAULT NULL, reply_to TINYTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', cc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', bcc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', subject_field VARCHAR(255) DEFAULT NULL, date_field DATETIME NOT NULL, body LONGTEXT NOT NULL, result VARCHAR(127) NOT NULL, failed_recipients LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Event (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city_id INT DEFAULT NULL, event_type_id INT DEFAULT NULL, venue_type_id INT DEFAULT NULL, event_ref VARCHAR(64) NOT NULL, title VARCHAR(128) NOT NULL, description VARCHAR(512) DEFAULT NULL, is_international TINYINT(1) NOT NULL, address VARCHAR(256) NOT NULL, budget DOUBLE PRECISION DEFAULT NULL, currency_id INT DEFAULT NULL, starting_date DATETIME DEFAULT NULL, ending_date DATETIME DEFAULT NULL, timing VARCHAR(128) DEFAULT NULL, comments VARCHAR(500) DEFAULT NULL, number_of_guests VARCHAR(64) DEFAULT NULL, UNIQUE INDEX UNIQ_FA6F25A35A0FB70 (event_ref), INDEX IDX_FA6F25A3A76ED395 (user_id), INDEX IDX_FA6F25A38BAC62AF (city_id), INDEX IDX_FA6F25A3401B253C (event_type_id), INDEX IDX_FA6F25A375847B4D (venue_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefRoleRight (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, right_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Document (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, document_type VARCHAR(32) NOT NULL, document_name VARCHAR(100) NOT NULL, document_size INT NOT NULL, UNIQUE INDEX UNIQ_211FE820F997F295 (document_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefEventType (id INT AUTO_INCREMENT NOT NULL, event_type VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_425FFE8293151B82 (event_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Service (id INT AUTO_INCREMENT NOT NULL, performance_id INT NOT NULL, title VARCHAR(128) NOT NULL, price DOUBLE PRECISION NOT NULL, currency_id INT NOT NULL, deposit_value DOUBLE PRECISION NOT NULL, deposit_type VARCHAR(32) NOT NULL, payment_terms VARCHAR(256) NOT NULL, comments VARCHAR(256) NOT NULL, UNIQUE INDEX UNIQ_2E20A34E2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ArtistAgenda (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, title VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, starting_datetime DATETIME NOT NULL, ending_datetime DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefPaymentType (id INT AUTO_INCREMENT NOT NULL, payment_type VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_7892C8B0AD5DC05D (payment_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EventOffer (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, offer_id INT DEFAULT NULL, status VARCHAR(32) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, currency_id INT DEFAULT NULL, deposit_value DOUBLE PRECISION DEFAULT NULL, deposit_type VARCHAR(32) DEFAULT NULL, payment_terms VARCHAR(256) DEFAULT NULL, comments VARCHAR(500) DEFAULT NULL, send_date_time DATETIME NOT NULL, read_date_time DATETIME DEFAULT NULL, INDEX IDX_E5A4975A71F7E88B (event_id), INDEX IDX_E5A4975A53C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Performance (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, tech_requirement VARCHAR(512) DEFAULT NULL, INDEX IDX_44B1956CCFA12B8 (profile_id), FULLTEXT INDEX search_index (title, tech_requirement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE performance_media (performance_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_328C1693B91ADEEE (performance_id), INDEX IDX_328C1693EA9FDD75 (media_id), PRIMARY KEY(performance_id, media_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Homespotlight (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_3BB95587EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ArtistRating (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, rating INT NOT NULL, title VARCHAR(128) DEFAULT NULL, comments VARCHAR(512) DEFAULT NULL, rating_date_time DATETIME NOT NULL, INDEX IDX_2D20242371F7E88B (event_id), INDEX IDX_2D202423B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefCity (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, latitude NUMERIC(18, 12) DEFAULT NULL, longitude NUMERIC(18, 12) DEFAULT NULL, UNIQUE INDEX UNIQ_CB4049F25E237E06 (name), INDEX IDX_CB4049F298260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, header VARCHAR(512) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_international TINYINT(1) DEFAULT \'0\' NOT NULL, performance_range INT DEFAULT NULL, payment_type_id INT NOT NULL, active TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_4EEA9393A76ED395 (user_id), FULLTEXT INDEX search_index (title, description, header), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_media (profile_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_9DF83EDECCFA12B8 (profile_id), INDEX IDX_9DF83EDEEA9FDD75 (media_id), PRIMARY KEY(profile_id, media_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_category (profile_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FF267870CCFA12B8 (profile_id), INDEX IDX_FF26787012469DE2 (category_id), PRIMARY KEY(profile_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefTranslation (id INT AUTO_INCREMENT NOT NULL, en VARCHAR(512) NOT NULL, fr VARCHAR(512) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InvoiceType (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, company_name VARCHAR(255) NOT NULL, street_address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, phone_num VARCHAR(50) NOT NULL, fax_num VARCHAR(50) NOT NULL, email_address VARCHAR(50) NOT NULL, name VARCHAR(255) NOT NULL, company_name2 VARCHAR(255) NOT NULL, street_address2 VARCHAR(255) NOT NULL, city2 VARCHAR(255) NOT NULL, zipcode2 VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, today_date DATE NOT NULL, invoice_id VARCHAR(255) NOT NULL, acted_id VARCHAR(255) NOT NULL, due_date DATE NOT NULL, description_service1 VARCHAR(255) NOT NULL, description_service2 VARCHAR(255) NOT NULL, service1_unitprice NUMERIC(9, 2) NOT NULL, service2_unitprice NUMERIC(9, 2) NOT NULL, service1_qty INT NOT NULL, service2_qty INT NOT NULL, is_service1_taxed TINYINT(1) NOT NULL, is_service2_taxed TINYINT(1) NOT NULL, service1_amount NUMERIC(9, 2) NOT NULL, service2_amount NUMERIC(9, 2) NOT NULL, subtotal_amount NUMERIC(9, 2) NOT NULL, taxable_amount NUMERIC(9, 2) NOT NULL, tax_rate NUMERIC(5, 2) NOT NULL, tax_amount NUMERIC(9, 2) NOT NULL, other_amount NUMERIC(9, 2) NOT NULL, total_amount NUMERIC(9, 2) NOT NULL, acted_company_name VARCHAR(255) NOT NULL, pdf_path VARCHAR(255) DEFAULT NULL, INDEX IDX_4FEA01F971F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefVenueType (id INT AUTO_INCREMENT NOT NULL, venue_type VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_13B0AE6E3AF85A81 (venue_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Message (id INT AUTO_INCREMENT NOT NULL, chat_room_id INT DEFAULT NULL, receiver_user_id INT DEFAULT NULL, sender_user_id INT DEFAULT NULL, subject VARCHAR(128) NOT NULL, message_text LONGTEXT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, send_date_time DATETIME NOT NULL, read_date_time DATETIME DEFAULT NULL, archived TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_790009E31819BCFA (chat_room_id), INDEX IDX_790009E3DA57E237 (receiver_user_id), INDEX IDX_790009E32A98155E (sender_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PerformanceContract (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, artist_address VARCHAR(255) NOT NULL, today_date DATE NOT NULL, artist_details VARCHAR(255) NOT NULL, client_details VARCHAR(255) NOT NULL, event_date DATE NOT NULL, event_location VARCHAR(255) NOT NULL, performance_description VARCHAR(255) NOT NULL, event_amount NUMERIC(9, 2) NOT NULL, currency VARCHAR(255) NOT NULL, deposit_amount NUMERIC(9, 2) NOT NULL, deposit_percent NUMERIC(5, 2) NOT NULL, balance_amount NUMERIC(9, 2) NOT NULL, balance_percent NUMERIC(5, 2) NOT NULL, balance_mode VARCHAR(255) NOT NULL, balance_when VARCHAR(255) NOT NULL, transportation VARCHAR(255) NOT NULL, accomodation VARCHAR(255) NOT NULL, special_terms LONGTEXT NOT NULL, last_call_date DATE NOT NULL, artist_name VARCHAR(255) NOT NULL, client_name VARCHAR(255) NOT NULL, pdf_path VARCHAR(255) DEFAULT NULL, INDEX IDX_E1E9353C71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ChatRoom (id INT AUTO_INCREMENT NOT NULL, offer_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, client_id INT DEFAULT NULL, event_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_467AA3AC53C674EE (offer_id), INDEX IDX_467AA3ACB7970CF8 (artist_id), INDEX IDX_467AA3AC19EB6921 (client_id), INDEX IDX_467AA3AC71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, root_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, background VARCHAR(255) DEFAULT NULL, lft INT NOT NULL, rgt INT NOT NULL, lvl INT NOT NULL, recommend TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), INDEX IDX_64C19C179066886 (root_id), INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Offer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, currency_id INT DEFAULT NULL, deposit_value DOUBLE PRECISION DEFAULT NULL, payment_terms VARCHAR(256) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E817A83A2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_performance (offer_id INT NOT NULL, performance_id INT NOT NULL, INDEX IDX_3F52A8F53C674EE (offer_id), INDEX IDX_3F52A8FB91ADEEE (performance_id), PRIMARY KEY(offer_id, performance_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefCurrency (id INT AUTO_INCREMENT NOT NULL, iso_code VARCHAR(3) NOT NULL, symbol VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_A6E0D71362B6A45E (iso_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefRole (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_B172C1AC77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MessageFile (id INT AUTO_INCREMENT NOT NULL, message_id INT NOT NULL, file_name INT NOT NULL, file_size INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EventExtra (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, name VARCHAR(128) NOT NULL, price DOUBLE PRECISION NOT NULL, currency_id INT NOT NULL, comments VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefRegion (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, latitude NUMERIC(18, 12) DEFAULT NULL, longitude NUMERIC(18, 12) DEFAULT NULL, UNIQUE INDEX UNIQ_73CCFFBD5E237E06 (name), INDEX IDX_73CCFFBDF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, email VARCHAR(100) NOT NULL, password_hash VARCHAR(256) NOT NULL, primary_phone VARCHAR(32) DEFAULT NULL, secondary_phone VARCHAR(32) DEFAULT NULL, active TINYINT(1) DEFAULT \'0\' NOT NULL, avatar VARCHAR(256) DEFAULT NULL, background VARCHAR(256) DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME 
        DEFAULT NULL, migrate int(11) DEFAULT 0, UNIQUE INDEX UNIQ_2DA17977E7927C74 (email), UNIQUE INDEX UNIQ_2DA17977D1594E00 (primary_phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ref_role (user_id INT NOT NULL, ref_role_id INT NOT NULL, INDEX IDX_A0972FEDA76ED395 (user_id), INDEX IDX_A0972FED1217717C (ref_role_id), PRIMARY KEY(user_id, ref_role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefRight (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_C62B09DA77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RefCountry (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_5FB97C505E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EventService (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, service_id INT NOT NULL, status VARCHAR(32) NOT NULL, price DOUBLE PRECISION NOT NULL, currency_id INT NOT NULL, deposit_value DOUBLE PRECISION NOT NULL, deposit_type VARCHAR(32) NOT NULL, payment_terms VARCHAR(256) NOT NULL, comments VARCHAR(256) NOT NULL, send_date_time DATETIME NOT NULL, read_date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Template (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, template LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Staff (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, role_id INT NOT NULL, signature VARCHAR(512) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, client_type VARCHAR(32) NOT NULL, company VARCHAR(128) NOT NULL, comments VARCHAR(512) NOT NULL, address VARCHAR(256) NOT NULL, city_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE QuotationType (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, company_name VARCHAR(255) NOT NULL, artist_name VARCHAR(255) NOT NULL, street_address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, phone_num VARCHAR(50) NOT NULL, fax_num VARCHAR(50) NOT NULL, email_address VARCHAR(50) NOT NULL, name VARCHAR(255) NOT NULL, company_name2 VARCHAR(255) NOT NULL, street_address2 VARCHAR(255) NOT NULL, city2 VARCHAR(255) NOT NULL, zipcode2 VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, timing VARCHAR(255) NOT NULL, special_instructions VARCHAR(255) NOT NULL, today_date DATE NOT NULL, quotation_id VARCHAR(255) NOT NULL, acted_id VARCHAR(255) NOT NULL, expire_date DATE NOT NULL, description_service1 VARCHAR(255) NOT NULL, description_service2 VARCHAR(255) NOT NULL, is_service1_taxed TINYINT(1) NOT NULL, is_service2_taxed TINYINT(1) NOT NULL, service1_amount NUMERIC(9, 2) NOT NULL, service2_amount NUMERIC(9, 2) NOT NULL, deposit_percent NUMERIC(5, 2) NOT NULL, deposit_amount NUMERIC(9, 2) NOT NULL, balance_percent NUMERIC(5, 2) NOT NULL, balance_amount NUMERIC(9, 2) NOT NULL, balance_when VARCHAR(255) NOT NULL, balance_mode VARCHAR(255) NOT NULL, additional_comments VARCHAR(255) NOT NULL, subtotal_amount NUMERIC(9, 2) NOT NULL, taxable_amount NUMERIC(9, 2) NOT NULL, tax_rate NUMERIC(5, 2) NOT NULL, tax_amount NUMERIC(9, 2) NOT NULL, other_amount NUMERIC(9, 2) NOT NULL, total_amount NUMERIC(9, 2) NOT NULL, pdf_path VARCHAR(255) DEFAULT NULL, INDEX IDX_F42B499D71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Media (id INT AUTO_INCREMENT NOT NULL, media_type VARCHAR(32) NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(256) NOT NULL, media_size INT DEFAULT NULL, position INT DEFAULT 0 NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, thumbnail VARCHAR(256) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Artist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city_id INT DEFAULT NULL, country_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, assistant_name VARCHAR(128) DEFAULT NULL, website VARCHAR(256) DEFAULT NULL, payment_details VARCHAR(512) DEFAULT NULL, vat_rate DOUBLE PRECISION DEFAULT NULL, comments VARCHAR(512) DEFAULT NULL, recommend INT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_6F593B1989D9B62 (slug), UNIQUE INDEX UNIQ_6F593B1A76ED395 (user_id), INDEX IDX_6F593B18BAC62AF (city_id), INDEX IDX_6F593B1F92F3E70 (country_id), FULLTEXT INDEX search_index (name, assistant_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A38BAC62AF FOREIGN KEY (city_id) REFERENCES RefCity (id)');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3401B253C FOREIGN KEY (event_type_id) REFERENCES RefEventType (id)');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A375847B4D FOREIGN KEY (venue_type_id) REFERENCES RefVenueType (id)');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id)');
        $this->addSql('ALTER TABLE Performance ADD CONSTRAINT FK_44B1956CCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id)');
        $this->addSql('ALTER TABLE performance_media ADD CONSTRAINT FK_328C1693B91ADEEE FOREIGN KEY (performance_id) REFERENCES Performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_media ADD CONSTRAINT FK_328C1693EA9FDD75 FOREIGN KEY (media_id) REFERENCES Media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Homespotlight ADD CONSTRAINT FK_3BB95587EA9FDD75 FOREIGN KEY (media_id) REFERENCES Media (id)');
        $this->addSql('ALTER TABLE ArtistRating ADD CONSTRAINT FK_2D20242371F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE ArtistRating ADD CONSTRAINT FK_2D202423B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
        $this->addSql('ALTER TABLE RefCity ADD CONSTRAINT FK_CB4049F298260155 FOREIGN KEY (region_id) REFERENCES RefRegion (id)');
        $this->addSql('ALTER TABLE Profile ADD CONSTRAINT FK_4EEA9393A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE profile_media ADD CONSTRAINT FK_9DF83EDECCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_media ADD CONSTRAINT FK_9DF83EDEEA9FDD75 FOREIGN KEY (media_id) REFERENCES Media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_category ADD CONSTRAINT FK_FF267870CCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_category ADD CONSTRAINT FK_FF26787012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE InvoiceType ADD CONSTRAINT FK_4FEA01F971F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E31819BCFA FOREIGN KEY (chat_room_id) REFERENCES ChatRoom (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E3DA57E237 FOREIGN KEY (receiver_user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E32A98155E FOREIGN KEY (sender_user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE PerformanceContract ADD CONSTRAINT FK_E1E9353C71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3ACB7970CF8 FOREIGN KEY (artist_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC19EB6921 FOREIGN KEY (client_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C179066886 FOREIGN KEY (root_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_performance ADD CONSTRAINT FK_3F52A8F53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_performance ADD CONSTRAINT FK_3F52A8FB91ADEEE FOREIGN KEY (performance_id) REFERENCES Performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE RefRegion ADD CONSTRAINT FK_73CCFFBDF92F3E70 FOREIGN KEY (country_id) REFERENCES RefCountry (id)');
        $this->addSql('ALTER TABLE user_ref_role ADD CONSTRAINT FK_A0972FEDA76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ref_role ADD CONSTRAINT FK_A0972FED1217717C FOREIGN KEY (ref_role_id) REFERENCES RefRole (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE QuotationType ADD CONSTRAINT FK_F42B499D71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Artist ADD CONSTRAINT FK_6F593B1A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Artist ADD CONSTRAINT FK_6F593B18BAC62AF FOREIGN KEY (city_id) REFERENCES RefCity (id)');
        $this->addSql('ALTER TABLE Artist ADD CONSTRAINT FK_6F593B1F92F3E70 FOREIGN KEY (country_id) REFERENCES RefCountry (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A71F7E88B');
        $this->addSql('ALTER TABLE ArtistRating DROP FOREIGN KEY FK_2D20242371F7E88B');
        $this->addSql('ALTER TABLE InvoiceType DROP FOREIGN KEY FK_4FEA01F971F7E88B');
        $this->addSql('ALTER TABLE PerformanceContract DROP FOREIGN KEY FK_E1E9353C71F7E88B');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC71F7E88B');
        $this->addSql('ALTER TABLE QuotationType DROP FOREIGN KEY FK_F42B499D71F7E88B');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3401B253C');
        $this->addSql('ALTER TABLE performance_media DROP FOREIGN KEY FK_328C1693B91ADEEE');
        $this->addSql('ALTER TABLE offer_performance DROP FOREIGN KEY FK_3F52A8FB91ADEEE');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A38BAC62AF');
        $this->addSql('ALTER TABLE Artist DROP FOREIGN KEY FK_6F593B18BAC62AF');
        $this->addSql('ALTER TABLE Performance DROP FOREIGN KEY FK_44B1956CCFA12B8');
        $this->addSql('ALTER TABLE profile_media DROP FOREIGN KEY FK_9DF83EDECCFA12B8');
        $this->addSql('ALTER TABLE profile_category DROP FOREIGN KEY FK_FF267870CCFA12B8');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A375847B4D');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E31819BCFA');
        $this->addSql('ALTER TABLE profile_category DROP FOREIGN KEY FK_FF26787012469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C179066886');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A53C674EE');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC53C674EE');
        $this->addSql('ALTER TABLE offer_performance DROP FOREIGN KEY FK_3F52A8F53C674EE');
        $this->addSql('ALTER TABLE user_ref_role DROP FOREIGN KEY FK_A0972FED1217717C');
        $this->addSql('ALTER TABLE RefCity DROP FOREIGN KEY FK_CB4049F298260155');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3A76ED395');
        $this->addSql('ALTER TABLE Profile DROP FOREIGN KEY FK_4EEA9393A76ED395');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E3DA57E237');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E32A98155E');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3ACB7970CF8');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC19EB6921');
        $this->addSql('ALTER TABLE user_ref_role DROP FOREIGN KEY FK_A0972FEDA76ED395');
        $this->addSql('ALTER TABLE Artist DROP FOREIGN KEY FK_6F593B1A76ED395');
        $this->addSql('ALTER TABLE RefRegion DROP FOREIGN KEY FK_73CCFFBDF92F3E70');
        $this->addSql('ALTER TABLE Artist DROP FOREIGN KEY FK_6F593B1F92F3E70');
        $this->addSql('ALTER TABLE performance_media DROP FOREIGN KEY FK_328C1693EA9FDD75');
        $this->addSql('ALTER TABLE Homespotlight DROP FOREIGN KEY FK_3BB95587EA9FDD75');
        $this->addSql('ALTER TABLE profile_media DROP FOREIGN KEY FK_9DF83EDEEA9FDD75');
        $this->addSql('ALTER TABLE ArtistRating DROP FOREIGN KEY FK_2D202423B7970CF8');
        $this->addSql('DROP TABLE tweedegolf_logged_message');
        $this->addSql('DROP TABLE Event');
        $this->addSql('DROP TABLE RefRoleRight');
        $this->addSql('DROP TABLE Document');
        $this->addSql('DROP TABLE RefEventType');
        $this->addSql('DROP TABLE Service');
        $this->addSql('DROP TABLE ArtistAgenda');
        $this->addSql('DROP TABLE RefPaymentType');
        $this->addSql('DROP TABLE EventOffer');
        $this->addSql('DROP TABLE Performance');
        $this->addSql('DROP TABLE performance_media');
        $this->addSql('DROP TABLE Homespotlight');
        $this->addSql('DROP TABLE ArtistRating');
        $this->addSql('DROP TABLE RefCity');
        $this->addSql('DROP TABLE Profile');
        $this->addSql('DROP TABLE profile_media');
        $this->addSql('DROP TABLE profile_category');
        $this->addSql('DROP TABLE RefTranslation');
        $this->addSql('DROP TABLE InvoiceType');
        $this->addSql('DROP TABLE RefVenueType');
        $this->addSql('DROP TABLE Message');
        $this->addSql('DROP TABLE PerformanceContract');
        $this->addSql('DROP TABLE ChatRoom');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE Offer');
        $this->addSql('DROP TABLE offer_performance');
        $this->addSql('DROP TABLE RefCurrency');
        $this->addSql('DROP TABLE RefRole');
        $this->addSql('DROP TABLE MessageFile');
        $this->addSql('DROP TABLE EventExtra');
        $this->addSql('DROP TABLE RefRegion');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE user_ref_role');
        $this->addSql('DROP TABLE RefRight');
        $this->addSql('DROP TABLE RefCountry');
        $this->addSql('DROP TABLE EventService');
        $this->addSql('DROP TABLE Template');
        $this->addSql('DROP TABLE Staff');
        $this->addSql('DROP TABLE Client');
        $this->addSql('DROP TABLE QuotationType');
        $this->addSql('DROP TABLE Media');
        $this->addSql('DROP TABLE Artist');
    }
}
