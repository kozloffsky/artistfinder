<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Form\ChatRoomTechnicalRequirementsCreateType;
use Acted\LegalDocsBundle\Form\ChatRoomTechnicalRequirementsCustomCreateType;
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

        $eventIds = array();
        foreach ($chatRoomList as $chatRoom) {
            $eventIds[] = $chatRoom->getEvent()->getId();
        }

        $requestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');
        $requestQuotationEnquiries = $requestQuotationRepo->findBy(array('event' => $eventIds));

        $chats = $serializer->toArray($chatRoomList, SerializationContext::create()
            ->setGroups(['chat_list']));

        $enquiries = $serializer->toArray($requestQuotationEnquiries, SerializationContext::create()
            ->setGroups(['enquiries']));

        foreach ($chats as &$chat) {
            foreach ($enquiries as $enquire) {
                if ($chat['event']['id'] == $enquire['event']['id']) {
                    $chat['event']['published_request'] = $enquire['status'];
                    break;
                }

            }
        }

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
        $chatRoomId = $request->get('chat');
        $user = $this->getUser();
        $chat = $this->getEM()->getRepository('ActedLegalDocsBundle:ChatRoom')->checkUserPermission($user, $chatRoomId);
        if (!$chat) {
            return $this->redirect($this->generateUrl('chat_room_list', ['userId' => $user->getId()]), 301);
        }
        $serializer = $this->get('jms_serializer');

        $chatRoom = $this->getEM()->getRepository('ActedLegalDocsBundle:ChatRoom')->find($chatRoomId);
        $quotationLink = $this->getQuotationLink($chatRoom);
        $chat = $serializer->toArray($chatRoom, SerializationContext::create()
            ->setGroups(['chat_room']));

        return $this->render('ActedLegalDocsBundle:ChatRoom:chat_room.html.twig',
            compact('chat', 'quotationLink'));
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

    public function bookingsAction(Request $request)
    {
        $userId = $request->get('userId');
        $chat = [];
        return $this->render('ActedLegalDocsBundle:ChatRoom:bookings.html.twig',
            compact('chat'));
    }


    public function pricesAction() {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $homespotlights = $em->getRepository('ActedLegalDocsBundle:Artist')->allSpotlightArtist();
        $homespotlight = $serializer->toArray($homespotlights, SerializationContext::create()
            ->setGroups(['block']));

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('ActedLegalDocsBundle:ChatRoom:prices.html.twig', compact('homespotlight', 'categories'));
    }

    public function technicalRequirementAction() {
        return $this->render('ActedLegalDocsBundle:ChatRoom:techreq.html.twig');
    }

    /**
     * Get link for Quotation pdf view\download.
     *
     * @param ChatRoom $chatRoom
     *
     * @return string
     */
    public function getQuotationLink(ChatRoom $chatRoom)
    {
        $em = $this->getDoctrine()->getManager();
        $quotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');
        $event = $chatRoom->getEvent();
        $quotation = $quotationRepo->findOneBy(['event'=> $event, 'status'=>true]);

        return "/".$quotation->getDocumentRequestQuotations()->first()->getPath();
    }

    /**
     * Add technical requirements to chat
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add technical requirements to chat",
     *  input="Acted\LegalDocsBundle\Form\ChatRoomTechnicalRequirementsCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addTechnicalRequirementsAction(Request $request)
    {
        $technicalRequirementsDirectory = $this->container->getParameter('document_technical_requirements_dir');
        $baseDir = $this->get('kernel')->getRootDir() . '/../web/';
        $fullPathTechnicalRequirementsDirectory = $baseDir . $technicalRequirementsDirectory;

        $serializer = $this->get('jms_serializer');

        $chatRoomTechnicalRequirementsCreateForm = $this->createForm(ChatRoomTechnicalRequirementsCreateType::class, null, ['method' => 'POST']);
        $chatRoomTechnicalRequirementsCreateForm->handleRequest($request);

        if ($chatRoomTechnicalRequirementsCreateForm->isSubmitted() && (!$chatRoomTechnicalRequirementsCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($chatRoomTechnicalRequirementsCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $data = $chatRoomTechnicalRequirementsCreateForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $chatRoom = $data['chat_room'];
        $technicalRequirement = $data['technical_requirement'];
        $documents = $technicalRequirement->getDocumentTechnicalRequirements();
        $oldChatTechnicalRequirements = $chatRoom->getTechnicalRequirements();

        $chatTechnicalRequirements = array(
            'title' => $technicalRequirement->getTitle(),
            'description' => $technicalRequirement->getDescription(),
            'documentTechnicalRequirements' => array()
        );

        $copiedFiles = array();
        foreach ($documents as $document) {
            $technicalRequirementsFilePath = $baseDir . $document->getFile();
            $ext = pathinfo($technicalRequirementsFilePath, PATHINFO_EXTENSION);
            $technicalRequirementsCopyFileName = /*'COPY_' .*/ uniqid() . '.' . $ext;
            $technicalRequirementsCopyFilePath = $fullPathTechnicalRequirementsDirectory . '/' . $technicalRequirementsCopyFileName;
            $copiedFiles[] = $technicalRequirementsCopyFilePath;
            copy($technicalRequirementsFilePath, $technicalRequirementsCopyFilePath);

            $infoFileCopy = pathinfo($technicalRequirementsCopyFilePath);

            //format json with data from TR
            $chatTechnicalRequirements['documentTechnicalRequirements'][] = array(
                'name' => $technicalRequirementsCopyFileName,
                'size' => $document->getSize(),
                'file' => $document->getFile(),
                'originalName' => $document->getOriginalName()
            );
        }

        $chatTechnicalRequirements = json_encode($chatTechnicalRequirements);

        $resultUpdated = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->updateTechnicalRequirements($chatRoom->getId(), $chatTechnicalRequirements);
        if (!$resultUpdated) {
            foreach ($copiedFiles as $copiedFile) {
                unlink($copiedFile);
            }

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Creating error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //check old technical requirements and remove elements related with one
        if (!empty($oldChatTechnicalRequirements)) {
            $oldChatTechnicalRequirements = json_decode($oldChatTechnicalRequirements);

            foreach ($oldChatTechnicalRequirements->documentTechnicalRequirements as $oldChatTechnicalRequirement) {
                unlink($fullPathTechnicalRequirementsDirectory . '/' . $oldChatTechnicalRequirement->name);
            }
        }

        return new JsonResponse([
            'status' => 'success',
            'technicalRequirements' => $chatTechnicalRequirements
        ]);
    }

    /**
     * Add custom technical requirements to chat
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add custom technical requirements to chat",
     *  input="Acted\LegalDocsBundle\Form\ChatRoomTechnicalRequirementsCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addCustomTechnicalRequirementsAction(Request $request)
    {
        $technicalRequirementsDirectory = $this->container->getParameter('document_technical_requirements_dir');
        $baseDir = $this->get('kernel')->getRootDir() . '/../web/';
        $fullPathTechnicalRequirementsDirectory = $baseDir . $technicalRequirementsDirectory;

        $serializer = $this->get('jms_serializer');

        $chatRoomCustomTechnicalRequirementsCustomCreateForm = $this->createForm(ChatRoomTechnicalRequirementsCustomCreateType::class, null, ['method' => 'POST']);
        $chatRoomCustomTechnicalRequirementsCustomCreateForm->handleRequest($request);

        if ($chatRoomCustomTechnicalRequirementsCustomCreateForm->isSubmitted() && (!$chatRoomCustomTechnicalRequirementsCustomCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($chatRoomCustomTechnicalRequirementsCustomCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $data = $chatRoomCustomTechnicalRequirementsCustomCreateForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $chatRoom = $data['chat_room'];
        $title = $data['title'];
        $description = $data['description'];
        $oldChatTechnicalRequirements = $chatRoom->getTechnicalRequirements();

        $user = $this->getUser();

        $chatTechnicalRequirements = array(
            'title' => $title,
            'description' => $description,
            'documentTechnicalRequirements' => array()
        );

        $chatTechnicalRequirements = json_encode($chatTechnicalRequirements);

        $resultUpdated = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->updateTechnicalRequirements($chatRoom->getId(), $chatTechnicalRequirements);
        if (!$resultUpdated) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Creating error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //check old technical requirements and remove elements related with one
        if (!empty($oldChatTechnicalRequirements)) {
            $oldChatTechnicalRequirements = json_decode($oldChatTechnicalRequirements);

            foreach ($oldChatTechnicalRequirements->documentTechnicalRequirements as $oldChatTechnicalRequirement) {
                unlink($fullPathTechnicalRequirementsDirectory . '/' . $oldChatTechnicalRequirement->name);
            }
        }

        return new JsonResponse([
            'status' => 'success',
            'technicalRequirements' => $chatTechnicalRequirements
        ]);
    }


    /**
     * Get chat by id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add custom technical requirements to chat",
     *  input="Acted\LegalDocsBundle\Form\ChatRoomTechnicalRequirementsCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param integer $chatRoomId
     * @return JsonResponse
     */
    public function getAction(Request $request, $chatRoomId)
    {
        $serializer = $this->get('jms_serializer');

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $chat = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->checkUserPermission($user, $chatRoomId);

        if (!$chat) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'You do not have permissions'
            ], Response::HTTP_FORBIDDEN);
        }

        $chatRoom = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->find($chatRoomId);

        return new JsonResponse([
            'status' => 'success',
            'chat' => $serializer->toArray(
                $chatRoom,
                SerializationContext::create()->setGroups(['chat_room'])
            )
        ]);
    }
}
