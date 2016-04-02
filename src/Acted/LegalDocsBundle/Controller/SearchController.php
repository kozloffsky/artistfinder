<?php

namespace Acted\LegalDocsBundle\Controller;

use Geocoder\Model\AddressCollection;
use Geocoder\Provider\GoogleMaps;
use Ivory\HttpAdapter\HttpAdapterFactory;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $curl = HttpAdapterFactory::create(HttpAdapterFactory::CURL);
        $geocoder = new GoogleMaps($curl);

        /** @var AddressCollection $result */
        $result = $geocoder->geocode('Paris');


        var_dump($result->first()->getLatitude());
        var_dump($result->first()->getLongitude());
        var_dump($result->first()->getCountry());
        die;
        return $this->render('', array('name' => 'search'));
    }
}
