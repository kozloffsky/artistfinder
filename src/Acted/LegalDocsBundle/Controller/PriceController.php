<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Entity\Service;
use Acted\LegalDocsBundle\Entity\PricePackage;
use Acted\LegalDocsBundle\Entity\PriceOption;
use Acted\LegalDocsBundle\Form\ArtistType;
use Acted\LegalDocsBundle\Form\PriceType;
use Acted\LegalDocsBundle\Form\OfferType;
use Acted\LegalDocsBundle\Form\ProfileType;
use Acted\LegalDocsBundle\Model\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Acted\LegalDocsBundle\Form\ProfileSettingsType;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class PriceController extends Controller
{
    public function createAction(Request $request)
    {

    }

}
