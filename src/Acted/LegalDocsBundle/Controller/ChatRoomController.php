<?php

namespace Acted\LegalDocsBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class ChatRoomController extends Controller
{
    public function getChatRoomListAction(Request $request)
    {
        $userId = $request->get('userId');
        $em = $this->getDoctrine()->getManager();
        $chatRoomList = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->findBy(['user' => $userId]);
    }

}