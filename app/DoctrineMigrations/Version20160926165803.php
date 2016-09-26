<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acted\LegalDocsBundle\Entity\Media;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160926165803 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('delete from Media where position = 2');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }

    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $performances = $em->getRepository('ActedLegalDocsBundle:Performance')->findAll();
        foreach ($performances as $performance) {
            $photo2 = new Media();
            $photo2->setName(uniqid());
            $photo2->setMediaType('photo');
            $photo2->setLink('/images/1.jpg');
            $photo2->setPosition(2);
            $photo2->setActive(true);
            $em->persist($photo2);
            $performance->addMedia($photo2);
        }
        $em->flush();
    }
}
