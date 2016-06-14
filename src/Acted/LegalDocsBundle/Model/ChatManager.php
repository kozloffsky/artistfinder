<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Doctrine\ORM\EntityManagerInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\Message;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Popo\EventOfferData;

/**
 * Manager for working with ChatRoom and Message
 * Class ChatManager
 * @package Acted\LegalDocsBundle\Model
 */
class ChatManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * ChatManager constructor.
     * @param EntityManagerInterface $entityManagerInterface
     * @param string $rootDir
     */
    public function __construct(EntityManagerInterface $entityManagerInterface, $rootDir)
    {
        $this->entityManager = $entityManagerInterface;
        $this->rootDir = $rootDir;
    }

    /**
     * Create new ChatRoom
     * @param Event $event
     * @param User $receiver
     * @param EventOfferData $data
     * @param Offer $offer
     */
    public function createChat($event, $receiver, $data, $offer)
    {
        $chat = $this->entityManager
            ->getRepository('ActedLegalDocsBundle:ChatRoom')
            ->getChatByParams($event, $receiver);

        if (!$chat) {
            $chatRoom = new ChatRoom();
            $chatRoom->setEvent($event);
            $chatRoom->setOffer($offer);
            $chatRoom->setArtist($receiver);
            $chatRoom->setClient($event->getUser());
            $this->entityManager->persist($chatRoom);
            if ($data->getComment()) {
                $message = $this->newChatMessage($chatRoom, $receiver, $data);
                $this->entityManager->persist($message);
            }
            $this->entityManager->flush();
        }
    }

    /**
     * Create new Message after create EventOffer
     * @param $chatRoom
     * @param $receiver
     * @param $data
     * @return Message
     */
    public function newChatMessage($chatRoom, $receiver, $data)
    {
        $now = new \DateTime();
        $message = new Message();
        $message->setChatRoom($chatRoom);
        $message->setReceiverUser($receiver);
        $message->setSenderUser($data->getUser());
        $message->setSubject($data->getName());
        $message->setMessageText($data->getComment());
        $message->setSendDateTime($now);

        return $message;
    }

    /**
     * @param ChatRoom $chatRoom
     * @param User $sender
     * @param User $receiver
     * @param string $messageText
     * @param string $filePath
     * @return  Message
     */
    public function newMessage(ChatRoom $chatRoom, User $sender, User $receiver, $messageText = null, $filePath = null)
    {
        $message = new Message();
        $now = new \DateTime();

        $message->setChatRoom($chatRoom);
        $message->setReceiverUser($receiver);
        $message->setSenderUser($sender);
        $message->setMessageText($messageText);
        $message->setFilePath($filePath);
        $message->setSubject($chatRoom->getEvent()->getTitle());
        $message->setSendDateTime($now);

        return $message;
    }
}