<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/8/16
 * Time: 17:15
 */

namespace Acted\LegalDocsBundle\Entity;


class OrderItemService extends OrderItem
{

    /**
     * @var Service
     */
    private $service;

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     * @return OrderItemService
     */
    public function setService(Service $service)
    {
        $this->service = $service;
        return $this;
    }



}
