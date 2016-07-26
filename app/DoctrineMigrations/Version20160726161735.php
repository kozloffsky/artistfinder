<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160726161735 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3A76ED395');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3A76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A53C674EE');
        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A71F7E88B');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Performance DROP FOREIGN KEY FK_44B1956CCFA12B8');
        $this->addSql('ALTER TABLE Performance ADD CONSTRAINT FK_44B1956CCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ArtistRating DROP FOREIGN KEY FK_2D202423B7970CF8');
        $this->addSql('ALTER TABLE ArtistRating ADD CONSTRAINT FK_2D202423B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Recommend DROP FOREIGN KEY FK_36094EF7B7970CF8');
        $this->addSql('ALTER TABLE Recommend ADD CONSTRAINT FK_36094EF7B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE InvoiceType DROP FOREIGN KEY FK_4FEA01F971F7E88B');
        $this->addSql('ALTER TABLE InvoiceType ADD CONSTRAINT FK_4FEA01F971F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E31819BCFA');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E32A98155E');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E3DA57E237');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E31819BCFA FOREIGN KEY (chat_room_id) REFERENCES ChatRoom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E32A98155E FOREIGN KEY (sender_user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E3DA57E237 FOREIGN KEY (receiver_user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC19EB6921');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC53C674EE');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC71F7E88B');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3ACB7970CF8');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC19EB6921 FOREIGN KEY (client_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3ACB7970CF8 FOREIGN KEY (artist_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE MessageFile DROP FOREIGN KEY FK_CE6F85EF537A1329');
        $this->addSql('ALTER TABLE MessageFile ADD CONSTRAINT FK_CE6F85EF537A1329 FOREIGN KEY (message_id) REFERENCES Message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE QuotationType DROP FOREIGN KEY FK_F42B499D71F7E88B');
        $this->addSql('ALTER TABLE QuotationType ADD CONSTRAINT FK_F42B499D71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Artist DROP FOREIGN KEY FK_6F593B1A76ED395');
        $this->addSql('ALTER TABLE Artist CHANGE spotlight spotlight INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Artist ADD CONSTRAINT FK_6F593B1A76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Artist DROP FOREIGN KEY FK_6F593B1A76ED395');
        $this->addSql('ALTER TABLE Artist CHANGE spotlight spotlight INT DEFAULT 0');
        $this->addSql('ALTER TABLE Artist ADD CONSTRAINT FK_6F593B1A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE ArtistRating DROP FOREIGN KEY FK_2D202423B7970CF8');
        $this->addSql('ALTER TABLE ArtistRating ADD CONSTRAINT FK_2D202423B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC53C674EE');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3ACB7970CF8');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC19EB6921');
        $this->addSql('ALTER TABLE ChatRoom DROP FOREIGN KEY FK_467AA3AC71F7E88B');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3ACB7970CF8 FOREIGN KEY (artist_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC19EB6921 FOREIGN KEY (client_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE ChatRoom ADD CONSTRAINT FK_467AA3AC71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3A76ED395');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A71F7E88B');
        $this->addSql('ALTER TABLE EventOffer DROP FOREIGN KEY FK_E5A4975A53C674EE');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE EventOffer ADD CONSTRAINT FK_E5A4975A53C674EE FOREIGN KEY (offer_id) REFERENCES Offer (id)');
        $this->addSql('ALTER TABLE InvoiceType DROP FOREIGN KEY FK_4FEA01F971F7E88B');
        $this->addSql('ALTER TABLE InvoiceType ADD CONSTRAINT FK_4FEA01F971F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E31819BCFA');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E3DA57E237');
        $this->addSql('ALTER TABLE Message DROP FOREIGN KEY FK_790009E32A98155E');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E31819BCFA FOREIGN KEY (chat_room_id) REFERENCES ChatRoom (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E3DA57E237 FOREIGN KEY (receiver_user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Message ADD CONSTRAINT FK_790009E32A98155E FOREIGN KEY (sender_user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE MessageFile DROP FOREIGN KEY FK_CE6F85EF537A1329');
        $this->addSql('ALTER TABLE MessageFile ADD CONSTRAINT FK_CE6F85EF537A1329 FOREIGN KEY (message_id) REFERENCES Message (id)');
        $this->addSql('ALTER TABLE Performance DROP FOREIGN KEY FK_44B1956CCFA12B8');
        $this->addSql('ALTER TABLE Performance ADD CONSTRAINT FK_44B1956CCFA12B8 FOREIGN KEY (profile_id) REFERENCES Profile (id)');
        $this->addSql('ALTER TABLE QuotationType DROP FOREIGN KEY FK_F42B499D71F7E88B');
        $this->addSql('ALTER TABLE QuotationType ADD CONSTRAINT FK_F42B499D71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Recommend DROP FOREIGN KEY FK_36094EF7B7970CF8');
        $this->addSql('ALTER TABLE Recommend ADD CONSTRAINT FK_36094EF7B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
    }
}
