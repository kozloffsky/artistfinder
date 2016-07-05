<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160704183750 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('delete from Media where media_type = "video" and position = 1');
        $this->addSql('DELETE FROM Media 
                            WHERE
                                id IN (SELECT 
                                    media_id
                                FROM
                                    (SELECT 
                                        COUNT(*) AS counter, media_id
                                    FROM
                                        performance_media AS t1
                                    LEFT JOIN Media AS t2 ON t1.media_id = t2.id
                                    
                                    WHERE
                                        position = 1
                                    GROUP BY performance_id
                                    HAVING counter > 1) aaa);');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
