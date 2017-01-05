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
use Doctrine\ORM\EntityNotFoundException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Entity\OrderItemPerformance;

use Symfony\Component\HttpFoundation\Request;

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
    public function payAction(Request $request, $orderId){
        if (!$this->orderManager->checkOrderForBooking($orderId)){

            $this->addFlash("warning", $this->orderManager->getLastError());
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render("@ActedLegalDocs/Order/payment.html.twig",['order'=>$orderId]);
    }

    public function paySuccessAction($orderId)
    {
        $order = $this->orderManager->bookOrder($orderId);
        if ($order == false) {
            throw $this->createNotFoundException("Error while booking");
        }

        return $this->redirect($this->generateUrl('chat_room_item',['chat'=>$order->getChat()->getId()]));
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
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollback();

            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'ok']);
    }

    public function saveDetailsAction(Request $request, $orderId){
        $data = [
            'email' => $request->get('c-email'),
            'name' => $request->get('c-name'),
            'person' => $request->get('c-person'),
            'phone' => $request->get('c-phone')
        ];

        $performanceStartTime = $request->get('performance_start_time');
        $additionalInfo = $request->get('additional_info');

        try{
            if (!is_null($performanceStartTime)) {
                $this->orderManager->setPerformanceStartTime($orderId, $performanceStartTime, $this->getUser()->getRoles()[0]);
            }

            if (!is_null($additionalInfo)) {
                $this->orderManager->setAdditionalInfo($orderId, $additionalInfo, $this->getUser()->getRoles()[0]);
            }

            $this->orderManager->setDetails($orderId, $data, $this->getUser()->getRoles()[0]);
        }catch(\Exception $e){
            return new JsonResponse(['error'=>$e->getMessage(), 500]);
        }

        return new JsonResponse(['status'=>'ok']);
    }

    public function saveTechReqsAction(Request $request, $orderId){
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'id' => $request->get('id')
        ];

        try{
            $this->orderManager->setTechReqs($orderId, ['requirement'=>$data]);
        }catch(\Exception $e){
            return new JsonResponse(['error'=>$e->getMessage(), 500]);
        }
        return new JsonResponse(['status'=>'ok'], 200);
    }


    public function saveStartTimeAction(Request $request, $orderId){
        $data = $request->get('performance-start-time');

        try{
            $this->orderManager->setPerformanceStartTime($orderId, $data);
        }catch(\Exception $e){
            return new JsonResponse(['error'=>$e->getMessage(), 500]);
        }
        return new JsonResponse(['status'=>'ok'], 200);
    }



    /**
     * @ApiDoc(
     *  description="Cancel order",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param $orderId
     * @param $type
     * @return JsonResponse
     */
    public function cancelOrderAction($orderId)
    {
        $response = ['status'=>'success'];

        try{
            $this->orderManager->cancelOrder($orderId);
        }catch (EntityNotFoundException $e){

            if (empty($type)) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('acted_legal_docs_homepage');
            }

            $response['status']  = 'error';
            $response['error'] = $e->getMessage();
        }

        if (empty($type)) {
            $this->addFlash('success', 'You rejected order');
            return $this->redirectToRoute('acted_legal_docs_homepage');
        }

        return new JsonResponse($response);
    }
}