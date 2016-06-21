<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

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
     *  description="et messages by filter archive|all|unread",
     *  filters={
     *      {"name"="filters", "dataType"="string"}
     *  },
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
     * Get logs sending email
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get logs sending email",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @return JsonResponse
     */
    public function showLogsAction()
    {
        $repo = $this->getDoctrine()->getRepository("TweedeGolfSwiftmailerLoggerBundle:LoggedMessage");
        $data = $repo->findAll();

        var_dump($data);die;
    }

    /**
     * Get chat
     * @param Request $request
     * @return  array
     */
    public function getChatAction(Request $request)
    {
        return $this->redirectToRoute('artists_list_by_category');
        $chatRoomId = $request->get('chat');
        $serializer = $this->get('jms_serializer');

        $chatRoom = $this->getEM()->getRepository('ActedLegalDocsBundle:ChatRoom')->find($chatRoomId);
        $chat = $serializer->toArray($chatRoom, SerializationContext::create()
            ->setGroups(['chat_room']));

        return $this->render('ActedLegalDocsBundle:ChatRoom:chat_room.html.twig',
            compact('chat'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function webSocketPushAction(Request $request)
    {
        $messageText = $request->request->get('message')?$request->request->get('message'):null;
        $uploadedFiles = $request->files->get('files');
        $chatId = $request->get('chatId');
        $filePaths = [];

        $user = $this->getUser();
        $chat = $this->getEM()->getRepository('ActedLegalDocsBundle:ChatRoom')->checkUserPermission($user, $chatId);
        if (!$chat) {
            return new JsonResponse(['error' => 'You are not have permission sending messages to this chat'], 400);
        }
        $pusher = $this->container->get('gos_web_socket.zmq.pusher');

        /** checking user is receiver or sender **/
        if ($chat->getArtist()->getId() == $user->getId()) {
            $sender = $chat->getArtist();
            $receiver = $chat->getClient();
        } else {
            $sender = $chat->getClient();
            $receiver = $chat->getArtist();
        }

        /** Add new message to chat room **/
        try {
            if ($uploadedFiles && !empty($uploadedFiles)) {
                $mediaManager = $this->get('app.media.manager');
                $uploadResult = $mediaManager->uploadFilesForMessage($uploadedFiles, 'chat_'.$chatId);
                if ($uploadResult['status'] === 'success') {
                    $filePaths = $uploadResult['message'];
                } else {
                    return new JsonResponse(['error' => $uploadResult['message']], 400);
                }
            }
            
            $message = $this->get('app.chat.manager')->newMessage($chat, $sender, $receiver, $messageText, $filePaths);
            $this->getEM()->persist($message);
            $this->getEM()->flush();

            $pusher->push(
                    [
                        'msg' => $messageText,
                        'avatar' => $user->getAvatar(),
                        'user_name' => $user->getFullName(),
                        'room' => $chatId,
                        'file' => $filePaths,
                        'role' => $user->getRoleName(),
                        'send_date' => $message->getTimeFromGet(),
                        'message_id' => $message->getId()
                    ],
                    'acted_topic_chat',
                    ['room' => $chatId]
                );

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['success' => 'Added new message to chat'], 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Add read date for unread message",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function readMessagesInChatAction(Request $request)
    {
        $chatId = $request->get('chatId');
        $user = $this->getUser();
        /** Check auth */
        if (!$user) {
            return new JsonResponse(['error' => 'Only auth user can visit chat'], 400);
        }
        $now = new \DateTime();
        try {
            $this->getEM()->getRepository('ActedLegalDocsBundle:Message')->updateReadDate($now, $user, $chatId);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['success'], 200);
    }

    /**
     * Count new messages from all chats
     * @return Response
     */
    public function countNewMessageAction()
    {
        $user = $this->getUser();
        /** Check auth */
        if (!$user) {
            return new Response(0);
        }
        $amount = $this->getEM()->getRepository('ActedLegalDocsBundle:Message')->countNewMessage($user);

        return new Response($amount['data']);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Add quotation to event offer",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addQuotationAction(Request $request)
    {
        $offerId = $request->get('id');

        
    }
}
