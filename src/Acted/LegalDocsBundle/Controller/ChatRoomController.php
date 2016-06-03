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
        $filter = $request->get('filter');

        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $chatRoomList = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->getChatRoomByParams($userId, $filter);

        $chats = $serializer->toArray($chatRoomList, SerializationContext::create()
            ->setGroups(['chat_list']));

        $uk = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneByName('United Kingdom');
        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();
        $regions = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findByCountry($uk);

        return $this->render('ActedLegalDocsBundle:ChatRoom:list.html.twig',
            compact('chats', 'categories', 'regions'));
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

    /**
     * Get chat
     * @param Request $request
     * @return  array
     */
    public function getMessageAction(Request $request)
    {
        $messageId = $request->get('message');
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $message = $em->getRepository('ActedLegalDocsBundle:Message')->find($messageId);
        $chat = $serializer->toArray($message, SerializationContext::create()
            ->setGroups(['message']));
        if(!$message->getReadDateTime()) {
            $now = new \DateTime();
            $message->setReadDateTime($now);
            $em->persist($message);
            $em->flush();
        }

        return $this->render('ActedLegalDocsBundle:ChatRoom:message.html.twig',
            compact('chat'));
    }

}