<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/12/16
 * Time: 10:54
 */

namespace Acted\LegalDocsBundle\Command;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Client;
use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\OrderItem;
use Acted\LegalDocsBundle\Entity\OrderItemPerformance;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateOrdersCommand extends ContainerAwareCommand
{


    protected function configure(){
        $this->setName('create:orders')
            ->setDescription('Create client entities for users with role ROLE_CLIENT ');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $res = $em->getRepository('ActedLegalDocsBundle:ChatRoom')->createQueryBuilder('c')

            //->where('c.order IS NULL')
            //->setParameter('role','ROLE_CLIENT')
            ->getQuery()->getResult();



        //var_dump($res);
        //$output->write($res);

        foreach($res as $chat){
            $tr = $em->getRepository('ActedLegalDocsBundle:TechnicalRequirement')->createQueryBuilder('r')
                ->where('r.artist = :artist')
                ->setParameter('artist', $chat->getArtist()->getArtist()->getId())->getQuery()->getResult(Query::HYDRATE_ARRAY);

            $order = new Order();
            $chat->setOrder($order);
            $order->setEvent($chat->getEvent());
            $order->setClient($chat->getEvent()->getUser()->getClient());
            $order->setArtist($chat->getArtist()->getArtist());
            $order->setTechnicalRequirements(['requirement'=>$tr[0]]);
            $order->setCreated(new \DateTime());
            $order->setUpdated(new \DateTime());
            $order->setStatus(ORDER::STATUS_NEW);
            $order->setTotalPrice(0);
            $order->setPaymentExpirationDate(new \DateTime());
            $order->setDepositAmount(50);
            $order->setDepositBallance(25);
            $order->setPerformanceStartTime("6.pm");
            $order->setAdditionalInfo("");
            $order->setGuaranteedBalanceTerm(70);
            $order->setGuaranteedDepositTerm(30);
            $order->setCurrency($chat->getEvent()->getCurrencyId());

            $pers = $em->getRepository('ActedLegalDocsBundle:Performance')
                ->getPerformancesForEvent($chat->getEvent()->getId());

            $total = 0;



            foreach($pers as $p){
                $oi = new OrderItemPerformance();
                $data = [];
                $data['performance'] = $p->getId();
                $data['performance_title'] = $p->getTitle();
                $oi->setPerformance($p);
                $data['packages'] = [];
                $packages = $p->getPackages();
                $price = 0;
                foreach($packages as $package){
                    if($package->getIsSelected()){
                        $pd = [];
                        $pd['package_id'] = $package->getId();
                        $pd['package_name'] = $package->getName();
                        $pd['options'] = [];
                        foreach ($package->getOptions() as $option){
                            if($option->getIsSelected()){
                                $od = [];
                                $od['option_id'] = $option->getId();
                                $od['option_duration'] = $option->getDuration();
                                $od['options'][] = $od;
                                foreach ($option->getRates() as $rate){
                                    if($rate->getIsSelected()){
                                        $price+=$rate->getPrice()->getAmount();
                                    }
                                }
                            }
                        }
                        $data['packages'][] = $pd;
                    }
                }
                $oi->setTotalPrice($price);
                $data['total'] = $price;
                var_dump($data);
                $oi->setData($data);
                $em->persist($oi);
                $order->addItem($oi);
                $total += $price;
            }

            $order->setTotalPrice($total);

            $em->persist($order);

        }

        $em->flush();
    }


    protected function getTechnicalRequirementForArtist(Artist $artist){

    }

}