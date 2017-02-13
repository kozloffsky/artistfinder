<?php
/**
 * Created by PhpStorm.
 * User: kozlo
 * Date: 2/13/2017
 * Time: 3:28 AM
 */

namespace Acted\LegalDocsBundle\Command;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixCountryPlaceIdCommand extends ContainerAwareCommand
{

    /**
     * @var EntityManager
     */
    private $em;
    protected function configure()
    {
        $this->setName('placeid:country:fix');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $repo = $this->em->getRepository('ActedLegalDocsBundle:RefCity');

        $cities = $repo->findAll();

        foreach ($cities as $city){
            if($city->getPlaceId() == null){
                $key = 'AIzaSyDLK8SupBcU-H0H0SF0PIar5UP-y-DCrTI';
                $apiUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=".$key.'&';
                $location = "location=".$city->getLatitude().','.$city->getLongitude();


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl.$location);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $response = curl_exec($ch);

                // If using JSON...
                $data = json_decode($response);
                // first result is city
                $city->setPlaceId($data->results[0]->place_id);
                $output->writeln('Set place id for '.$city->getName().' to '.$city->getPlaceId());
                $this->em->persist($city);
            }
        }
        $this->em->flush();
    }
}