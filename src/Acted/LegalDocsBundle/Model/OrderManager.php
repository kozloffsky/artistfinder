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
use Acted\LegalDocsBundle\Entity\OrderItemService;
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

    private $lastError;

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
            throw new \Exception('order for this artist from this event already exists');
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
        $order->setDepositAmount(0);

        $order->setPerformanceStartTime("");
        $order->setAdditionalInfo("");
        $order->setGuaranteedBalanceTerm(20);
        $order->setGuaranteedDepositTerm(80);
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
        $order->setDepositBallance($total);

        $this->entityManager->persist($order);

        return $order;
    }


    public function getOrdersForEvent($event, $status = null)
    {
        $parameters = array(
            "event" => $event,
        );

        if (!is_null($status)) {
            $parameters["status"] = $status;
        }

        return $this->orderRepository->findBy($parameters);
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
        if ($order == null) {
            $this->lastError = "Order with id ".$orderId." not found";
            return false;
        }

        if ($order->getDetailsAccepted() != true ||
            $order->getTechnicalRequirementsAccepted() != true ||
            $order->getActsExtrasAccepted() != true ||
            $order->getTimingAccepted() != true
            ){
            $this->lastError =  "details not accepted";
            return false;
        }

        if($order->getActorDetails() == null || $order->getClientDetails() == null){
            $this->lastError = "details are empty";
            return false;
        }

        if($order->getStatus() > Order::STATUS_ACCEPTED){
            $this->lastError = "wrong status";
            return false;
        }

        return true;
    }


    public function bookOrder($orderId){
        $order = $this->orderRepository->find($orderId);

        if (!$this->checkOrderForBooking($orderId)){
            return false;
        }

        $order->setStatus(Order::STATUS_BOOKED);

        //Amount of money sent to escrow as deposit
        $order->setDepositBallance($order->getDepositToPay());
        //Amount of money left to pay
        $order->setDepositBallance($order->getBalanceToPay());

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function setDetails($orderId, $data, $userRole){
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new EntityNotFoundException("Order Not Found with id".$orderId);
        }

        if($userRole == "ROLE_CLIENT"){
            $order->setClientDetails($data);
        }else{
            $order->setActorDetails($data);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function setPerformanceStartTime($orderId, $performanceStartTime, $userRole=null){
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new EntityNotFoundException("Order Not Found with id".$orderId);
        }

        $order->setPerformanceStartTime($performanceStartTime);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function setAdditionalInfo($orderId, $additionalInfo, $userRole){
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new EntityNotFoundException("Order Not Found with id".$orderId);
        }

        $order->setAdditionalInfo($additionalInfo);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function setTechReqs($orderId, $data){
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new EntityNotFoundException("Order Not Found with id ".$orderId);
        }
        $order->setTechnicalRequirements($data);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }



    public function updateOrder($orderId, $extraPerformances, $performances, $services, $paymentDetails)
    {
        $orderRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:Order');
        $order = $orderRepo->find($orderId);

        $total = 0;
        $extraPerformanceTotal = 0;
        $performanceTotal = 0;
        $serviceTotal = 0;

        //remove old items related with order
        $orderItemRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:OrderItem');
        $orderItems = $orderItemRepo->findBy(array(
            'order' => $order
        ));

        foreach ($orderItems as $orderItem) {
            $this->entityManager->remove($orderItem);
        }

        if (!empty($performances)) {
            $resultPreparingPerformances = $this->preparePerformances($performances, $order);
            $order = $resultPreparingPerformances['order'];
            $performanceTotal = $resultPreparingPerformances['total'];
        }

        if (!empty($services)) {
            $resultPreparingServices = $this->prepareServices($services, $order);
            $order = $resultPreparingServices['order'];
            $serviceTotal = $resultPreparingServices['total'];
        }

        if (!empty($extraPerformances)) {
            $resultPreparingExtraPerformances = $this->preparePerformances($extraPerformances, $order, true);
            $order = $resultPreparingExtraPerformances['order'];
            $extraPerformanceTotal = $resultPreparingExtraPerformances['total'];
        }

        $total = $extraPerformanceTotal + $performanceTotal + $serviceTotal;

        $order->setTotalPrice($total);
        $order->setStatus(Order::STATUS_ACCEPTED);
        $order->setGuaranteedDepositTerm($paymentDetails['depositPercent']);
        $order->setGuaranteedBalanceTerm($paymentDetails['balancePercent']);

        $this->entityManager->persist($order);

        $this->entityManager->flush();
    }

    public function prepareServices($services, $order)
    {
        $total = 0;
        foreach($services as $service){
            $orderItemService = new OrderItemService();
            $serviceData = [];
            $serviceData['service'] = $service['id'];
            $serviceData['title'] = $service['title'];
            $serviceData['packages'] = [];

            $packages = $service['packages'];
            $price = 0;
            foreach ($packages as $package) {
                $packageData = [];
                $packageData['id'] = $package['id'];
                $packageData['name'] = $package['title'];
                $packageData['options'] = [];
                $optionData['rates'] = array();
                foreach ($package['options'] as $option) {
                    $currentAmount = $option['price'];
                    $optionData = [];
                    $optionData['id'] = $option['id'];
                    $optionData['duration'] = null;
                    $optionData['qty'] = null;

                    $rateData = array(
                        "id" => null,
                        "price" => array(
                            "id" => null,
                            "amount" => $currentAmount
                        )
                    );

                    $optionData['rates'][] = $rateData;

                    $price += $currentAmount;
                    $packageData['options'][] = $optionData;
                }

                $serviceData['packages'][] = $packageData;

            }

            $orderItemService->setTotalPrice($price);
            $serviceData['total'] = $price;
            $orderItemService->setData($serviceData);
            $this->entityManager->persist($orderItemService);
            $order->addItem($orderItemService);
            $orderItemService->setOrder($order);
            $total += $price;
        }

        return array(
            'order' => $order,
            'total' => $total
        );
    }

    public function preparePerformances($performances, $order, $isExtra = false)
    {
        $total = 0;
        foreach($performances as $performance){
            $orderItemPerformance = new OrderItemPerformance();
            $performanceData = [];
            $performanceData['performance'] = $performance['id'];
            $performanceData['title'] = $performance['title'];
            $performanceData['type'] = $performance['type'];

            if ($isExtra) {
                $performanceData['comment'] = $performance['comment'];
            }

            $performanceData['packages'] = [];

            $packages = $performance['packages'];
            $price = 0;
            foreach ($packages as $package) {
                $packageData = [];
                $packageData['id'] = $package['id'];
                $packageData['name'] = $package['title'];

                if ($isExtra) {
                    $packageData['isSelected'] = $package['isSelected'];
                }

                $packageData['options'] = [];
                $optionData['rates'] = array();
                foreach ($package['options'] as $option) {
                    $currentAmount = $option['price'];
                    $optionData = [];
                    $optionData['id'] = $option['id'];
                    $optionData['duration'] = $option['duration'];
                    $optionData['qty'] = $option['qty'];

                    $rateData = array(
                        "id" => null,
                        "price" => array(
                            "id" => null,
                            "amount" => $currentAmount
                        )
                    );

                    $optionData['rates'][] = $rateData;

                    $price += $currentAmount;
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

        return array(
            'order' => $order,
            'total' => $total
        );
    }

    public function cancelOrder($orderId){
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new EntityNotFoundException("Order Not Found with id".$orderId);
        }

        $order->setStatus(Order::STATUS_CANCELED);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    /**
     * @return mixed
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    public function setNotAvailableOrder($orderId)
    {
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new EntityNotFoundException("Order Not Found with id: " . $orderId);
        }

        $order->setStatus(Order::STATUS_NOT_AVAILABLE);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}