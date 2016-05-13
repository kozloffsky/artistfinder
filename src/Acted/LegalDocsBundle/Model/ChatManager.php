<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Doctrine\ORM\EntityManagerInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\Message;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Popo\CreateEvent;

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
     * @param User $receiver
     * @param CreateEvent $data
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
            $chatRoom->setUser($receiver);
            $message = $this->newChatMessage($chatRoom, $receiver, $data);
            $this->entityManager->persist($chatRoom);
            $this->entityManager->persist($message);

            $this->entityManager->flush();
        }
    }

    /**
     * @param $chatRoom
     * @param $receiver
     * @param $data
     * @return Message
     */
    public function newChatMessage($chatRoom, $receiver, $data)
    {
        $date = $data->getEventDate();
        $now = new \DateTime();
        $perfName = [];
        foreach ($data->getPerformance() as $perf) {
            $perfName[] = $perf->getTitle();
        }

        $body = sprintf('Dear, %s!
             I would like to enquire about your availability and price for our upcoming event in %s lease kindly find below more information about our event.
              Event: %s;
              Timing: %s;
              Date: %s;
              Venue: %s;
              Location: %s;
              Number of guests: %s;
              Event type: %s;
              Additional comment: %s;
              I am interested in the following acts: %s',
            $receiver->getFirstName(), $data->getCity()->getName(), $data->getName(), $data->getEventTime(),
            $date->format('Y/m/d'), $data->getVenueType()->getVenueType(), $data->getLocation(),
            $data->getNumberOfGuests(),  $data->getType()->getEventType(), $data->getComment(), implode(',', $perfName));
        $message = new Message();
        $message->setChatRoom($chatRoom);
        $message->setReceiverUser($receiver);
        $message->setSenderUser($data->getUser());
        $message->setSubject($data->getName());
        $message->setMessageText($body);
        $message->setSendDateTime($now);

        return $message;
    }

}