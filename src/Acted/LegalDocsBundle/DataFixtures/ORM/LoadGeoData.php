<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 1:40
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\RefCity;
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefRegion;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGeoData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $france = new RefCountry();
        $france->setName('France');
        $uk = new RefCountry();
        $uk->setName('United Kingdom');
        $germany = new RefCountry();
        $germany->setName('Germany');

        $oxford = new RefRegion();
        $oxford->setName('Oxford');
        $oxford->setCountry($uk);
        $reading = new RefRegion();
        $reading->setName('Reading');
        $reading->setCountry($uk);
        $brighton = new RefRegion();
        $brighton->setName('Brighton');
        $brighton->setCountry($uk);
        $london = new RefRegion();
        $london->setName('London');
        $london->setCountry($uk);

        $baden = new RefRegion();
        $baden->setName('Baden-Württemberg');
        $baden->setCountry($germany);
        $bavaria = new RefRegion();
        $bavaria->setName('Bavaria');
        $bavaria->setCountry($germany);
        $hesse = new RefRegion();
        $hesse->setName('Hesse');
        $hesse->setCountry($germany);
        $berlin = new RefRegion();
        $berlin->setName('Berlin');
        $berlin->setCountry($germany);

        $britanny = new RefRegion();
        $britanny->setName('Brittany');
        $britanny->setCountry($france);
        $corsica = new RefRegion();
        $corsica->setName('Corsica');
        $corsica->setCountry($france);
        $ile = new RefRegion();
        $ile->setName('Île-de-France');
        $ile->setCountry($france);

        $manager->persist($uk);
        $manager->persist($germany);
        $manager->persist($france);

        $this->addReference('uk', $uk);
        $this->addReference('germany', $germany);
        $this->addReference('france', $france);

        $manager->persist($oxford);
        $manager->persist($reading);
        $manager->persist($brighton);
        $manager->persist($baden);
        $manager->persist($bavaria);
        $manager->persist($hesse);
        $manager->persist($britanny);
        $manager->persist($corsica);
        $manager->persist($ile);
        $manager->persist($london);
        $manager->persist($berlin);

        $this->addReference('london', $london);
        $this->addReference('berlin', $berlin);
        $this->addReference('ile-de-france', $ile);

        $city1 = new RefCity();
        $city1->setName('London');
        $city1->setRegion($london);

        $city2 = new RefCity();
        $city2->setName('Paris');
        $city2->setRegion($ile);

        $city3 = new RefCity();
        $city3->setName('Berlin');
        $city3->setRegion($berlin);

        $city4 = new RefCity();
        $city4->setName('Benson');
        $city4->setRegion($oxford);

        $city5 = new RefCity();
        $city5->setName('Chalgrove');
        $city5->setRegion($oxford);

        $city6 = new RefCity();
        $city6->setName('Wheatley');
        $city6->setRegion($oxford);

        $city7 = new RefCity();
        $city7->setName('Slough');
        $city7->setRegion($reading);

        $city8 = new RefCity();
        $city8->setName('Maidenhead');
        $city8->setRegion($reading);

        $city9 = new RefCity();
        $city9->setName('Newbury');
        $city9->setRegion($reading);

        $city10 = new RefCity();
        $city10->setName('Henfield');
        $city10->setRegion($brighton);

        $city11 = new RefCity();
        $city11->setName('Hassocks');
        $city11->setRegion($brighton);

        $city12 = new RefCity();
        $city12->setName('Woodmancote');
        $city12->setRegion($brighton);


        $city13 = new RefCity();
        $city13->setName('Croydon');
        $city13->setRegion($london);

        $city14 = new RefCity();
        $city14->setName('Havering');
        $city14->setRegion($london);

        $city15 = new RefCity();
        $city15->setName('Enfield');
        $city15->setRegion($london);

        $city16 = new RefCity();
        $city16->setName('Stuttgart');
        $city16->setRegion($baden);

        $city17 = new RefCity();
        $city17->setName('Mannheim');
        $city17->setRegion($baden);

        $city18 = new RefCity();
        $city18->setName('Friburg');
        $city18->setRegion($baden);

        $city19 = new RefCity();
        $city19->setName('Munich');
        $city19->setRegion($bavaria);

        $city20 = new RefCity();
        $city20->setName('Nuremberg');
        $city20->setRegion($bavaria);

        $city21 = new RefCity();
        $city21->setName('Augsburg');
        $city21->setRegion($bavaria);

        $city22 = new RefCity();
        $city22->setName('Darmstadt');
        $city22->setRegion($hesse);

        $city23 = new RefCity();
        $city23->setName('Frankfurt');
        $city23->setRegion($hesse);

        $city24 = new RefCity();
        $city24->setName('Kassel');
        $city24->setRegion($hesse);

        $city25 = new RefCity();
        $city25->setName('Nantes');
        $city25->setRegion($britanny);

        $city26 = new RefCity();
        $city26->setName('Rennes');
        $city26->setRegion($britanny);

        $city27 = new RefCity();
        $city27->setName('Vannes');
        $city27->setRegion($britanny);

        $city28 = new RefCity();
        $city28->setName('Ajaccio');
        $city28->setRegion($corsica);

        $city29 = new RefCity();
        $city29->setName('Bastia');
        $city29->setRegion($corsica);

        $city30 = new RefCity();
        $city30->setName('Bonifacio');
        $city30->setRegion($corsica);

        $city31 = new RefCity();
        $city31->setName('Saint-Denis');
        $city31->setRegion($ile);

        $city32 = new RefCity();
        $city32->setName('Créteil');
        $city32->setRegion($ile);

        $city33 = new RefCity();
        $city33->setName('Fontainebleau');
        $city33->setRegion($ile);


        for ($i = 1; $i <= 33; $i++) {
            $cityName = 'city'.$i;
            $manager->persist($$cityName);
            $this->addReference('city'.$i, $$cityName);

        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}