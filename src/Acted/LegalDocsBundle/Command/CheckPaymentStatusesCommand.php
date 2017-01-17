<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 1/16/17
 * Time: 11:03
 */

namespace Acted\LegalDocsBundle\Command;


use Acted\LegalDocsBundle\Entity\Message;
use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\SystemLog;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckPaymentStatusesCommand extends ContainerAwareCommand
{


    protected function configure(){
        $this->setName('payment:check')
            ->setDescription('Check order dates and generate statuses for payments');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $this->notifyOrders(
            '1_day_deadline',
            new \DateTime(),
            new \DateTime('tomorrow'),
            '1 day deadline notify',
            '1 day deadline notify for quote'
            );

        $this->notifyOrders(
            '2_weeks_deadline',
            new \DateTime('- 2 weeks'),
            new \DateTime('yesterday'),
            '2 weeks pay ballance notify',
            '2 weeks pay ballance notify for quote'
        );
    }

    private function notifyOrders($key, $startDate, $endDate, $mailMessage, $mailSubject){
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $orderRepository = $em->getRepository('ActedLegalDocsBundle:Order');

        $orders = $orderRepository->createQueryBuilder('o')
            ->join('o.event','e')
            ->where('e.startingDate > :start AND e.startingDate < :end')
            ->setParameter(':start', $startDate)
            ->setParameter(':end', $endDate)
            ->getQuery()->execute();



        foreach ($orders as $order){
            $oldLog = $em->getRepository('ActedLegalDocsBundle:SystemLog')
                ->findBy(['message' => $key.':'.$order->getId()]);

            if(!empty($oldLog) || $order->getStatus() != Order::STATUS_BOOKED) continue;
            $log = new SystemLog();
            $log->setIsReaded(true);
            $log->setMessage($key.':'.$order->getId());
            $log->setLogDate(new \DateTime());
            $log->setTargetUserId($order->getClient()->getUser()->getId());

            $em->persist($log);


            try {
                $this->sendNotificationEmail(
                    $order->getClient()->getUser()->getEmail(),
                    $mailMessage,
                    $mailSubject . $order->getId());

                $chatMessage = new Message();
                $chatMessage->setChatRoom($order->getChat());
                $chatMessage->setReceiverUser($order->getClient()->getUser());
                $chatMessage->setSenderUser($order->getArtist()->getUser());
                $chatMessage->setMessageText($mailMessage);
                $chatMessage->setSendDateTime(new \DateTime());
                $em->persist($chatMessage);
            }catch(\Exception $e){
                echo $e->getMessage().PHP_EOL;
            }

            $em->flush();
        }
    }

    private function sendNotificationEmail($email, $body, $subject){
        $mailer = $this->getContainer()->get('mailer');
        $message = new \Swift_Message();
        $message->addTo($email);
        $message->setSubject($subject);
        $message->setBody($body);
        $message->setSender('pay@acted.co');
        $mailer->send($message);
    }

}