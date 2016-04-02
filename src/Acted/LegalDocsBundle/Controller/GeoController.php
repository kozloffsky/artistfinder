<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Form\CountryFilterType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class GeoController extends Controller
{
    /**
     * Regions list
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieve regions list by country",
     *  input="Acted\LegalDocsBundle\Form\CountryFilterType",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when the country ID is invalid",
     *  }
     * )
     */
    public function regionAction(Request $request)
    {
        $countryForm = $this->createForm(CountryFilterType::class);
        $countryForm->handleRequest($request);

        $serializer = $this->get('jms_serializer');

        if ($countryForm->isSubmitted() && $countryForm->isValid()) {
            $data = $countryForm->getData();

            /** @var RefCountry $country */
            $country = $data['country'];

            return new JsonResponse($serializer->toArray($country->getRegions()));
        }

        return new JsonResponse($this->get('app.form_errors_serializer')->serializeFormErrors($countryForm), 400);
    }
}
