<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Form\CountryFilterType;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;


class GeoController extends Controller
{
    /**
     * Regions list
     * @Rest\View
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

        if ($countryForm->isSubmitted() && $countryForm->isValid()) {
            $data = $countryForm->getData();

            /** @var RefCountry $country */
            $country = $data['country'];

            return $country->getRegions();
        }

        return View::create($this->get('app.form_errors_serializer')->serializeFormErrors($countryForm), 400);
    }
}
