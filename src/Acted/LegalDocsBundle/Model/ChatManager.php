<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Doctrine\ORM\EntityManagerInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;

class ChatManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ChatManager constructor.
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }

    /**
     * @param Event $event
     * @param User $user
     */
    public function createChat($event, $user)
    {
        $chat = $this->entityManager
            ->getRepository('ActedLegalDocsBundle:ChatRoom')
            ->getChatByParams($event, $user);

        if (!$chat) {
            $chatRoom = new ChatRoom();
            $chatRoom->setEvent($event);
            $chatRoom->setChatRef(uniqid());
            $chatRoom->setUser($user);
            $this->entityManager->persist($chatRoom);

            $this->entityManager->flush();
        }
    }

}