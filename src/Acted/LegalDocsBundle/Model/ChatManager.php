<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\MessageFile;
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
        $chatRoom = new ChatRoom();
        $chatRoom->setEvent($event);
        $chatRoom->setOffer($offer);
        $chatRoom->setArtist($receiver);
        $chatRoom->setClient($event->getUser());
        $this->entityManager->persist($chatRoom);
        if ($data->getComment()) {
            $message = $this->newChatMessage($chatRoom, $receiver, $data);
            $this->entityManager->persist($message);
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
        $text = $data->getComment() ? $data->getComment() : '';
        $now = new \DateTime();
        $message = new Message();
        $message->setChatRoom($chatRoom);
        $message->setReceiverUser($receiver);
        $message->setSenderUser($data->getUser());
        $message->setSubject($data->getName());
        $message->setMessageText($text);
        $message->setSendDateTime($now);

        return $message;
    }

    /**
     * @param ChatRoom $chatRoom
     * @param User $sender
     * @param User $receiver
     * @param string $messageText
     * @param array $filePaths
     * @return  Message
     */
    public function newMessage(ChatRoom $chatRoom, User $sender, User $receiver, $messageText = null, $filePaths = [])
    {
        $message = new Message();
        $now = new \DateTime();

        $message->setChatRoom($chatRoom);
        $message->setReceiverUser($receiver);
        $message->setSenderUser($sender);
        $message->setMessageText($messageText);
        $message->setSubject($chatRoom->getEvent()->getTitle());
        $message->setSendDateTime($now);
        foreach ($filePaths as $file) {
            $messageFile = new MessageFile();
            $messageFile->setFileName($file['path']);
            $messageFile->setMessage($message);

            $message->addFile($messageFile);
        }

        return $message;
    }
}