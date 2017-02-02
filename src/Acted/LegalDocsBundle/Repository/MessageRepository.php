<?php

namespace Acted\LegalDocsBundle\Repository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $userId
     * @param string $filter
     * @return array
     */
    public function getAllMessages($userId, $filter = null)
    {
        $query = $this->createQueryBuilder('m')
                      ->where('m.receiverUser = :userId')
                      ->setParameter('userId', $userId)
                      ->andWhere('m.hidden = :hidden')
                      ->setParameter('hidden', false);

        if ($filter) {
            switch ($filter) {
                case 'archived':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', true);
                    break;
                case 'all':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', false);
                    break;
                case 'unread':
                    $query
                        ->andWhere('m.readDateTime IS null');
                    break;
            }
        } else {
            $query
                ->andWhere('m.archived = :archived')
                ->setParameter('archived', false);
        }


        return $query->getQuery()->getResult();
    }

    /**
     * @param int $userId
     * @param string $filter
     * @return array
     */
    public function getChatRoomMessage($userId, $chatRoomId, $filter = null)
    {
        $query = $this->createQueryBuilder('m')
                      ->where('m.receiverUser = :userId')
                      ->setParameter('userId', $userId)
                      ->andWhere('m.chatRoom = :chatRoom')
                      ->setParameter('chatRoom', $chatRoomId)
                      ->andWhere('m.hidden = :hidden')
                      ->setParameter('hidden', false);

        if ($filter) {
            switch ($filter) {
                case 'archived':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', true);
                    break;
                case 'all':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', false);
                    break;
                case 'unread':
                    $query
                        ->andWhere('m.readDateTime IS null');
                    break;
            }
        } else {
            $query
                ->andWhere('m.archived = :archived')
                ->setParameter('archived', false);
        }

        $query->orderBy('m.sendDateTime', 'desc')
              ->setMaxResults(1);

        return $query->getQuery()->getResult();
    }

    /**
     * @param DateTime $now
     * @param User $user
     * @param int $chatId
     */
    public function updateReadDate($now, $user, $chatId)
    {
        $this->createQueryBuilder('m')
             ->update('ActedLegalDocsBundle:Message', 'm')
             ->set('m.readDateTime', '?1')
             ->where('m.receiverUser = :user')
             ->andWhere('m.chatRoom = :chatRoom')
             ->setParameters([
                 1          => $now,
                 'user'     => $user,
                 'chatRoom' => $chatId
             ])
             ->getQuery()->execute();
    }

    /**
     * Count unread messages from all chats
     * @param User $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countNewMessage($user)
    {
        return $this->createQueryBuilder('m')
                    ->select('COUNT(m.id) as data')
                    ->where('m.receiverUser = :user')
                    ->andWhere('m.readDateTime IS NULL')
                    ->setParameter('user', $user)
                    ->getQuery()->getOneOrNullResult();
    }

    public function getMessagesGroupedByChatRoom($userId, $filter = null)
    {
        $query = $this->createQueryBuilder('m')
                      ->where('m.receiverUser = :userId')
                      ->setParameter('userId', $userId);

        if ($filter) {
            switch ($filter) {
                case 'archived':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', true);
                    break;
                case 'all':
                    $query
                        ->andWhere('m.archived = :archived')
                        ->setParameter('archived', false);
                    break;
                case 'unread':
                    $query
                        ->andWhere('m.readDateTime IS null');
                    break;
            }
        } else {
            $query
                ->andWhere('m.archived = :archived')
                ->setParameter('archived', false);
        }

        $query->orderBy('m.sendDateTime');

        return $query->getQuery()->getResult();
    }
}
