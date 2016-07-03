<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\SerializationContext;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $homespotlights = $em->getRepository('ActedLegalDocsBundle:Artist')->allSpotlightArtist();
        $homespotlight = $serializer->toArray($homespotlights, SerializationContext::create()
            ->setGroups(['block']));

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('ActedLegalDocsBundle:Default:index.html.twig',
            compact('homespotlight', 'categories'));
    }
}
