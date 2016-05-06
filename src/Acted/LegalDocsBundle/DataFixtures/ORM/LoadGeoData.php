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

        $southEast = new RefRegion();
        $southEast->setName('South East');
        $southEast->setCountry($uk);
        $southEast->setLatitude('51.081785');
        $southEast->setLongitude('0.597509');

        $southWest = new RefRegion();
        $southWest->setName('South West');
        $southWest->setCountry($uk);
        $southWest->setLatitude('51.460340');
        $southWest->setLongitude('-2.586934');

        $eastEngland = new RefRegion();
        $eastEngland->setName('East England');
        $eastEngland->setCountry($uk);
        $eastEngland->setLatitude('52.346329');
        $eastEngland->setLongitude('0.516073');

        $londonArea = new RefRegion();
        $londonArea->setName('London Area');
        $londonArea->setCountry($uk);
        $londonArea->setLatitude('51.5073509');
        $londonArea->setLongitude('-0.1277583');

        $baden = new RefRegion();
        $baden->setName('Baden-Württemberg');
        $baden->setCountry($germany);
        $baden->setLatitude('48.6616037');
        $baden->setLongitude('9.3501336');

        $bavaria = new RefRegion();
        $bavaria->setName('Bavaria');
        $bavaria->setCountry($germany);
        $bavaria->setLatitude('48.7904472');
        $bavaria->setLongitude('11.4978895');

        $hesse = new RefRegion();
        $hesse->setName('Hesse');
        $hesse->setCountry($germany);
        $hesse->setLatitude('50.6520515');
        $hesse->setLongitude('9.1624376');

        $berlin = new RefRegion();
        $berlin->setName('Berlin Area');
        $berlin->setCountry($germany);
        $berlin->setLatitude('52.5200066');
        $berlin->setLongitude('13.4049540');

        $britanny = new RefRegion();
        $britanny->setName('Brittany');
        $britanny->setCountry($france);
        $britanny->setLatitude('48.2020471');
        $britanny->setLongitude('-2.9326435');

        $corsica = new RefRegion();
        $corsica->setName('Corsica');
        $corsica->setCountry($france);
        $corsica->setLatitude('42.172569');
        $corsica->setLongitude('9.169498');

        $ile = new RefRegion();
        $ile->setName('Île-de-France');
        $ile->setCountry($france);
        $ile->setLatitude('48.8499198');
        $ile->setLongitude('2.6370411');

        $manager->persist($uk);
        $manager->persist($germany);
        $manager->persist($france);

        $this->addReference('uk', $uk);
        $this->addReference('germany', $germany);
        $this->addReference('france', $france);

        $manager->persist($southEast);
        $manager->persist($southWest);
        $manager->persist($eastEngland);
        $manager->persist($baden);
        $manager->persist($bavaria);
        $manager->persist($hesse);
        $manager->persist($britanny);
        $manager->persist($corsica);
        $manager->persist($ile);
        $manager->persist($londonArea);
        $manager->persist($berlin);

        $this->addReference('london', $londonArea);
        $this->addReference('berlin', $berlin);
        $this->addReference('ile-de-france', $ile);

        $city1 = new RefCity();
        $city1->setName('London');
        $city1->setRegion($londonArea);

        $city2 = new RefCity();
        $city2->setName('Paris');
        $city2->setRegion($ile);

        $city3 = new RefCity();
        $city3->setName('Berlin');
        $city3->setRegion($berlin);

        $city4 = new RefCity();
        $city4->setName('Oxford');
        $city4->setRegion($southEast);

        $city5 = new RefCity();
        $city5->setName('Winchester');
        $city5->setRegion($southEast);

        $city6 = new RefCity();
        $city6->setName('Southampton');
        $city6->setRegion($southEast);

        $city7 = new RefCity();
        $city7->setName('Bristol');
        $city7->setRegion($southWest);

        $city8 = new RefCity();
        $city8->setName('Plymouth');
        $city8->setRegion($southWest);

        $city9 = new RefCity();
        $city9->setName('Poole');
        $city9->setRegion($southWest);

        $city10 = new RefCity();
        $city10->setName('Luton');
        $city10->setRegion($eastEngland);

        $city11 = new RefCity();
        $city11->setName('Norwich');
        $city11->setRegion($eastEngland);

        $city12 = new RefCity();
        $city12->setName('Southend-on-Sea');
        $city12->setRegion($eastEngland);


        $city13 = new RefCity();
        $city13->setName('Swindon');
        $city13->setRegion($southWest);

        $city14 = new RefCity();
        $city14->setName('Brighton');
        $city14->setRegion($southEast);

        $city15 = new RefCity();
        $city15->setName('Reading');
        $city15->setRegion($southEast);
        $city15->setLatitude('51.453682');
        $city15->setLongitude('-0.977338');

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