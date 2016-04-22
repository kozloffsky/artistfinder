<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 0:55
 */

namespace Acted\LegalDocsBundle\EventListener;


use Acted\LegalDocsBundle\Geo\Geo;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Geocoder\Exception\NoResult;
use Geocoder\Model\AddressCollection;
use Geocoder\Provider\GoogleMaps;
use Ivory\HttpAdapter\HttpAdapterFactory;

class GeoListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Geo) {
            return;
        }

        $curl = HttpAdapterFactory::create(HttpAdapterFactory::FILE_GET_CONTENTS);
        $geocoder = new GoogleMaps($curl, null, null, true, 'AIzaSyALRdjNjF9CsRTWzyyHMjorLmCsoVRNpEE');

        /** @var AddressCollection $result */
        try {
            $addresses = $geocoder->geocode($entity->getName());
        } catch (NoResult $e) {
            return;
        }

        if ($address = $addresses->first()) {
            $entity->setLatitude($address->getLatitude());
            $entity->setLongitude($address->getLongitude());
        }
    }

}