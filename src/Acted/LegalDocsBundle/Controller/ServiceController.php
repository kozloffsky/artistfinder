<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Service;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Form\ServiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Acted\LegalDocsBundle\Entity\PricePackage;
use Acted\LegalDocsBundle\Entity\PriceOption;
use Acted\LegalDocsBundle\Entity\PriceOptionRate;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $service = new Service();
        $serviceForm = $this->createForm(ServiceType::class);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $data = $serviceForm->getData();
        $artist = $data['artist'];
        $profile = $artist->getUser()->getProfile();


        $service->setTitle($data['title']);
        $service->setProfile($profile);
        $service->setIsVisible(false);
        $em->persist($service);


        $price = new Price();
        $price->setProfile($profile);
        $price->addService($service);
        //\Doctrine\Common\Util\Debug::dump($price);exit;
        $em->persist($price);
        $em->flush();
        \Doctrine\Common\Util\Debug::dump('!!!');exit;


        $pricePackage = new PricePackage();
        $pricePackage->setName($data['package_name']);
        $pricePackage->setPrice($price);
        $em->persist($pricePackage);
        $em->flush();

        $priceOption = new PriceOption();
        $priceOption->setPricePackage($pricePackage);
        $em->persist($priceOption);
        $em->flush();

        $priceOptionRate = new PriceOptionRate();
        $priceOptionRate->setPrice($data['price']);
        $em->persist($priceOptionRate);
        $em->flush();

        \Doctrine\Common\Util\Debug::dump('!!!');exit;
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

    public function editAction(Request $request, Service $service)
    {

    }
}
