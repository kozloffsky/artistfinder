<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/15/16
 * Time: 15:31
 */

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\OrderItemService;
use Acted\LegalDocsBundle\Model\OrderManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Entity\OrderItemPerformance;


class OrderController extends Controller
{

    /**
     * @DI\Inject("acted_legal_docs.model.order_manager")
     * @var OrderManager
     */
    private $orderManager;

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @DI\Inject("jms_serializer")
     * @var Serializer
     */
    private $serializer;

    /**
     * @ApiDoc(
     *  description="Gets order by id",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param $orderId
     * @return JsonResponse
     */
    public function getOrderByIdAction($orderId)
    {
        $order = $this->orderManager->getOrderById($orderId);
        return new JsonResponse(
            $this->serializer->toArray($order, SerializationContext::create()->setGroups('order')));
    }


    public function acceptOrderFieldAction($orderId, $fieldId, $value)
    {
        try {
            $this->orderManager->acceptFieldById($orderId, $fieldId, $value);
        }catch(\Exception $e){
            return new JsonResponse(['status'=>"error", "message"=>$e->getMessage()],500);
        }

        return new JsonResponse(['status'=>'ok']);

    }

    /**
     * Here goes actual payment
     * TODO: Here will be mongopay, right now faking this and manually create payment transaction and book order
     * @param $orderId
     */
    public function payAction($orderId){
        if (!$this->orderManager->checkOrderForBooking($orderId)){
            $this->createNotFoundException("Bad Order");
        }
        return $this->render("@ActedLegalDocs/Order/payment.html.twig",['order'=>$orderId]);
    }

    public function paySuccessAction($orderId)
    {
        if (!$this->orderManager->bookOrder($orderId)) {
            $this->createNotFoundException("Error while booking");
        }
    }

    /**
     * @ApiDoc(
     *  description="Update order",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param $orderId
     * @return JsonResponse
     */
    public function updateOrderAction($orderId)
    {
        $extraPerformances = $this->get('request')->request->get('extraPerformances');
        $performances = $this->get('request')->request->get('performances');
        $services = $this->get('request')->request->get('services');
        $paymentDetails = $this->get('request')->request->get('paymentDetails');


        $this->entityManager->getConnection()->beginTransaction();
        //$this->entityManager->getConnection()->setAutoCommit(false);

        try {
            $this->orderManager->updateOrder($orderId, $extraPerformances, $performances, $services, $paymentDetails);
            $this->entityManager->getConnection()->commit();
        }catch(\Exception $e){
            $this->entityManager->getConnection()->rollback();

            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status'=>'ok']);
    }
}