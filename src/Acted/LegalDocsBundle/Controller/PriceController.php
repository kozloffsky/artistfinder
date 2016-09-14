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
        $service = null;
        $performance = null;

        $serializer = $this->get('jms_serializer');


        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $priceForm = $this->createForm(PriceType::class);
        $priceForm->handleRequest($request);

        if ($priceForm->isSubmitted() && (!$priceForm->isValid())) {
            return new JsonResponse($serializer->toArray($priceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }


        $data = $priceForm->getData();
        if (empty($data['performance_title']) && empty($data['service_title'])) {
            return new JsonResponse(['error' => 'Performance or service can not be empty'], Response::HTTP_BAD_REQUEST);
        }

        $profile = $data['artist']->getUser()->getProfile();

        if (!empty($data['performance_title'])) {
            $performance = new Performance();

            $performance->setProfile($profile);
            $performance->setStatus(Performance::STATUS_PUBLISHED);
            $performance->setTitle($data['performance_title']);
            $performance->setIsVisible(false);
            $em->persist($performance);
            //$em->flush();
        }

        if (!empty($data['service_title'])) {
            $service = new Service();

            $service->setTitle($data['service_title']);
            $service->setIsVisible(false);
            $em->persist($service);
            //$em->flush();
        }


        $price = new Price();
        $price->setProfile($profile);
        $price->addPerformance($performance);
        $price->addService($service);
        $em->persist($price);


        $pricePackage = new PricePackage();
        $pricePackage->setName($data['package_name']);
        $pricePackage->setPrice($price);
        $em->persist($pricePackage);


        /*$priceOption = new PriceOption();
        $price->addPerformance($profile);
        $price->addPerformance($performance);
        $price->addService($service);
        $em->persist($service);*/



        \Doctrine\Common\Util\Debug::dump($data);exit;
        /*$data['post_code'] = (empty($data['post_code']) ? '' : $data['post_code']);
        $data['account_name'] = (empty($data['account_name']) ? '' : $data['account_name']);
        $data['account_number'] = (empty($data['account_number']) ? '' : $data['account_number']);
        $data['bank_name'] = (empty($data['bank_name']) ? '' : $data['bank_name']);
        $data['billing_address'] = (empty($data['billing_address']) ? '' : $data['billing_address']);
        $data['iban'] = (empty($data['iban']) ? '' : $data['iban']);
        $data['swift_code'] = (empty($data['swift_code']) ? '' : $data['swift_code']);
        $data['vat_number'] = (empty($data['vat_number']) ? '' : $data['vat_number']);


        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setPostcode($data['post_code']);

        if (!empty($data['password'])) {
            $user = $userManager->updatePassword($user, $data['password']);
        }


        $artist->setName($data['name']);
        $artist->setCountry($data['country']);
        $artist->setCity($data['city']);

        $paymentSettingRepo = $em->getRepository('ActedLegalDocsBundle:PaymentSetting');

        $paymentSettingObj = $paymentSettingRepo->findOneBy(array(
            'user' => $user
        ));

        if (empty($paymentSettingObj)) {
            $paymentSettingObj = new PaymentSetting();
        }

        $paymentSettingObj->setAccountName($data['account_name']);
        $paymentSettingObj->setAccountNumber($data['account_number']);
        $paymentSettingObj->setBankName($data['bank_name']);
        $paymentSettingObj->setBillingAddress($data['billing_address']);
        $paymentSettingObj->setIban($data['iban']);
        $paymentSettingObj->setSwiftCode($data['swift_code']);
        $paymentSettingObj->setVatNumber($data['vat_number']);
        $paymentSettingObj->setUser($user);

        $em->persist($paymentSettingObj);
        $em->flush();*/

        return new JsonResponse(array('status'=>'success')/*$serializer->toArray($user)*/);
    }

}
