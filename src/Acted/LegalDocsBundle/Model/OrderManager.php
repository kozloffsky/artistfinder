<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/8/16
 * Time: 18:28
 */

namespace Acted\LegalDocsBundle\Model;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\Client;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\OrderItemPerformance;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Repository\OrderItemRepository;
use Acted\LegalDocsBundle\Repository\OrderRepository;
use Acted\LegalDocsBundle\Repository\PerformanceRepository;
use Acted\LegalDocsBundle\Repository\TechnicalRequirementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Orm\Query;

class OrderManager
{
    /**
     * @var OrderRepository
     * @return Order
     */
    private $orderRepository;

    /**
     * @var OrderItemRepository
     */
    private $orderItemRepository;

    /**
     * @var TechnicalRequirementRepository
     */
    private $technicalRequirementsRepository;

    /**
     * @var PerformanceRepository
     */
    private $performanceRepository;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->orderItemRepository = $entityManager->getRepository("ActedLegalDocsBundle:OrderItem");
        $this->orderRepository = $entityManager->getRepository("ActedLegalDocsBundle:Order");
        $this->technicalRequirementsRepository = $entityManager->getRepository("ActedLegalDocsBundle:TechnicalRequirement");
        $this->performanceRepository = $entityManager->getRepository("ActedLegalDocsBundle:Performance");
    }

    /**
     * Creates new quote order for event to artist
     * @param Event $event
     * @param Artist $artist
     * @param Client $client
     * @param $performances
     * @return Order
     * @throws UniqueConstraintViolationException
     */
    public function createOrder(Event $event,
                                Artist $artist,
                                Client $client,
                                ArrayCollection $performances,
                                ChatRoom $chatRoom = null
                                ){

        if($this->orderRepository->findOneBy(['event'=>$event, 'artist'=>$artist, 'client'=>$client])){
            //todo: DO NOT FORDET UNCOMMENT AFTER TESTING!!!!
            //throw new \Exception('order for this artist from this event already exists');
        }

        $artistTechnicalRequirements = $this->technicalRequirementsRepository->createQueryBuilder('r')
            ->where('r.artist = :artist')
            ->setParameter('artist', $artist->getId())
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);


        $requirement = [];
        if (!empty($artistTechnicalRequirements)){
            $requirement = $artistTechnicalRequirements[0];
        }

        $order = new Order();
        //todo create chat room for new order
        //$chat->setOrder($order);
        $order->setEvent($event);
        $order->setClient($client);
        $order->setArtist($artist);
        $order->setTechnicalRequirements(['requirement'=>$requirement]);
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
        $order->setCurrency($event->getCurrencyId());

        if($chatRoom != null){
            $chatRoom->setOrder($order);
        }

        /*$performances = $this->performanceRepository
            ->getPerformancesForEvent($event->getId());*/

        $total = 0;



        foreach($performances as $performance){
            $orderItemPerformance = new OrderItemPerformance();
            $performanceData = [];
            $performanceData['performance'] = $performance->getId();
            $performanceData['title'] = $performance->getTitle();
            $performanceData['type'] = $performance->getType();
            $orderItemPerformance->setPerformance($performance);
            $performanceData['packages'] = [];
            $packages = $performance->getPackages();
            $price = 0;
            foreach ($packages as $package) {

                $packageData = [];
                $packageData['id'] = $package->getId();
                $packageData['name'] = $package->getName();
                $packageData['options'] = [];
                foreach ($package->getOptions() as $option) {
                    $optionData = [];
                    $optionData['id'] = $option->getId();
                    $optionData['duration'] = $option->getDuration();
                    $optionData['qty'] = $option->getQty();
                    $optionData['rates'] = [];
                    foreach ($option->getRates() as $rate) {
                        $currentAmount = $rate->getPrice()->getAmount();
                        $price += $currentAmount;
                        $priceId = $rate->getPrice()->getId();

                        $rateData = array(
                            "id" => $rate->getId(),
                            "price" => array(
                                "id" => $priceId,
                                "amount" => (int)$currentAmount
                            )
                        );
                        $optionData['rates'][] = $rateData;
                    }

                    $packageData['options'][] = $optionData;
                }

                $performanceData['packages'][] = $packageData;

            }
            $orderItemPerformance->setTotalPrice($price);
            $performanceData['total'] = $price;
            $orderItemPerformance->setData($performanceData);
            $this->entityManager->persist($orderItemPerformance);
            $order->addItem($orderItemPerformance);
            $orderItemPerformance->setOrder($order);
            $total += $price;
        }

        $order->setTotalPrice($total);

        $this->entityManager->persist($order);

        return $order;
    }


    public function getOrdersForArtist(Artist $artist)
    {
        return $this->orderRepository->createQueryBuilder('ord')
            ->join("ord.items", 'oi')
            ->where('ord.artist = :artist')
            ->setParameter('artist', $artist)->getQuery()->setFetchMode('Order','items',ClassMetadata::FETCH_EAGER)
            ->getResult();
    }


    public function getOrderById($orderId)
    {
        return $this->orderRepository->find($orderId);
    }

    public function acceptFieldById($orderId, $fieldId, $value = true){
        $order = $this->orderRepository->find($orderId);
        if (! $order){
            throw new EntityNotFoundException("Order not found");
        }

        switch ($fieldId){
            case Order::FIELD_TECHNICAL_REQUIREMENTS:
                $order->setTechnicalRequirementsAccepted($value);
                break;

            case Order::FIELD_ACTS_EXTRAS:
                $order->setActsExtrasAccepted($value);
                break;

            case Order::FIELD_TIMING:
                $order->setTimingAccepted($value);
                break;

            case Order::FIELD_DETAILS:
                $order->setDetailsAccepted($value);
                break;
            default:
                throw new \Exception("Wrong field");
                break;
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function checkOrderForBooking($orderId){
        $order = $this->orderRepository->find($orderId);
        if (! $order){
            return false;
        }

        if ($order->getDetailsAccepted() != true ||
            $order->getTechnicalRequirementsAccepted() != true ||
            $order->getActsExtrasAccepted() != true ||
            $order->getTimingAccepted() != true
            ){
            return false;
        }

        if(empty($order->getActorDetails()) || empty($order->getClientDetails())){
            return false;
        }
    }

    public function bookOrder($orderId){
        $order = $this->orderRepository->find($orderId);

        if (!$this->checkOrderForBooking($orderId)){
            $this->createNotFoundException("Bad Order");
        }

        $order->setStatus(Order::STATUS_BOOKED);

        //Amount of money sent to escrow as deposit
        $order->setDepositBallance($order->getDepositToPay());
        //Amount of money left to pay
        $order->setDepositBallance($order->getBalanceToPay());

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return true;
    }




}