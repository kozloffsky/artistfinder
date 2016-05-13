<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

class ChatRoomController extends Controller
{
    /**
     * List of chatRoom
     * @param Request $request
     * @return  array
     */
    public function getChatRoomListAction(Request $request)
    {
        $userId = $request->get('userId');
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $chatRoomList = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->findBy(['user' =>$userId]);
        $chats = $serializer->toArray($chatRoomList, SerializationContext::create()
            ->setGroups(['chat_list']));

        return $this->render('ActedLegalDocsBundle:ChatRoom:list.html.twig',
            compact('chats'));
    }

    /**
     * Get chat
     * @param Request $request
     * @return  array
     */
    public function getChatAction(Request $request)
    {
        $chatRoomId = $request->get('chat');
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $chatRoom = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->find($chatRoomId);
        $chat = $serializer->toArray($chatRoom, SerializationContext::create()
            ->setGroups(['chat_room']));

        return $this->render('ActedLegalDocsBundle:ChatRoom:chat_room.html.twig',
            compact('chat'));
    }

}