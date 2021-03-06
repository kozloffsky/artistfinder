<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\User;

/**
 * MessageFileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageFileRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function getFileByUser(User $user)
    {
        return $this->createQueryBuilder('f')
            ->join('f.message', 'm')
            ->where('m.receiverUser = :user')
            ->orWhere('m.senderUser = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getChatRoomFiles(ChatRoom $room){
        return $this->createQueryBuilder('f')
            ->join('f.message','m')
            ->where('m.chatRoom = :room')
            ->setParameter('room', $room)
            ->getQuery()
            ->getResult();
    }
}
