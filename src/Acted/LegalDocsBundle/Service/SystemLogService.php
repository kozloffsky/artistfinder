<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 1/14/17
 * Time: 15:36
 */

namespace Acted\LegalDocsBundle\Service;


use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\SystemLog;
use Acted\LegalDocsBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Gos\Bundle\WebSocketBundle\Pusher\PusherInterface;

class SystemLogService
{

    /**
     * @var EntityManager
     */
    private $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function log(User $target, $message){
        $log = new SystemLog();
        $log->setTargetUserId($target->getId());
        $log->setMessage($message);
        $log->setLogDate(new \DateTime());
        $log->setIsReaded(false);

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    public function getNotifications(User $target){
         $qb = $this->entityManager
            ->getRepository("ActedLegalDocsBundle:SystemLog")->createQueryBuilder('n');
        $notifications = $qb
            ->where($qb->expr()->andX(
                $qb->expr()->eq('n.targetUserId',':userId'),
                $qb->expr()->eq('n.isReaded',':isReaded')
            ))
            ->setParameter(':userId', $target->getId())
            ->setParameter(':isReaded', false)->getQuery()->getResult();

        foreach ($notifications as $notification) {
            $notification->setIsReaded(true);
            $this->entityManager->persist($notification);
        }

        $this->entityManager->flush();

        return $notifications;
    }

}