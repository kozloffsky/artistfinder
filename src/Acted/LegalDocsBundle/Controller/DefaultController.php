<?php

namespace Acted\LegalDocsBundle\Controller;

use JMS\Serializer\SerializationContext;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $fakeUsers = $this->container->getParameter('fake_users');
        switch ($fakeUsers) {
            case 'show':
                $fake = 0;
                break;
            case 'hide':
                $fake = 1;
                break;
        }

        $homespotlights = $em->getRepository('ActedLegalDocsBundle:Artist')->allSpotlightArtist($fake);
        $homespotlight = $serializer->toArray($homespotlights, SerializationContext::create()
            ->setGroups(['block']));

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('ActedLegalDocsBundle:Default:index.html.twig',
            compact('homespotlight', 'categories'));
    }

    public function howItWorksAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('ActedLegalDocsBundle:Default:how-it-works.html.twig',
            compact('categories'));
    }
}
