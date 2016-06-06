<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ChatRoomController extends Controller
{
    /**
     * List of chatRooms
     * @param Request $request
     * @return  array
     */
    public function getChatRoomListAction(Request $request)
    {
        $userId = $request->get('userId');

        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $chatRoomList = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->getChatRoomByParams($userId);

        $chats = $serializer->toArray($chatRoomList, SerializationContext::create()
            ->setGroups(['chat_list']));

        $uk = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneByName('United Kingdom');
        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();
        $regions = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findByCountry($uk);

        return $this->render('ActedLegalDocsBundle:ChatRoom:list.html.twig',
            compact('chats', 'categories', 'regions'));
    }

    /**
     * Get all messages by filter
     * @param Request $request
     * @return  array
     */
    public function getAllMessagesAction(Request $request)
    {
        $userId = $request->get('userId');

        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $data = $em->getRepository('ActedLegalDocsBundle:Message')->getAllMessages($userId);
        $messages = $serializer->toArray($data, SerializationContext::create()
            ->setGroups(['all_messages']));

        $uk = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneByName('United Kingdom');
        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();
        $regions = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findByCountry($uk);

        return $this->render('ActedLegalDocsBundle:ChatRoom:all_messages.html.twig',
            compact('messages', 'categories', 'regions'));
    }

    /**
     * Get messages by filter
     * @ApiDoc(
     *  description="et messages by filter",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllMessageByFilterAction(Request $request)
    {
        $userId = $request->get('userId');
        $filters = $request->query->get('filters');
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $data = $em->getRepository('ActedLegalDocsBundle:Message')->getAllMessages($userId, $filters);
        $messages = $serializer->toArray($data, SerializationContext::create()
            ->setGroups(['all_messages']));

        return new JsonResponse($messages);

    }

    /**
     * Archived message
     * @ApiDoc(
     *  description="Archived message",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function archivedMessageAction(Request $request)
    {
        $messageId = $request->get('messageId');
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('ActedLegalDocsBundle:Message')->find($messageId);
        $message->setArchived(true);
        $em->persist($message);
        $em->flush();

        return new JsonResponse(['success' => 'Success archived!']);
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