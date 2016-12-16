<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/15/16
 * Time: 15:31
 */

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Model\OrderManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\DiExtraBundle\Annotation as DI;

class OrderController extends Controller
{

    /**
     * @DI\Inject("acted_legal_docs.model.order_manager")
     * @var OrderManager
     */
    private $orderManager;

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
        //var_dump($order);
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
}