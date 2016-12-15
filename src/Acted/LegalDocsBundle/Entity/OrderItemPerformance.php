<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/8/16
 * Time: 17:10
 */

namespace Acted\LegalDocsBundle\Entity;


class OrderItemPerformance extends OrderItem
{
    /**
     * @var Performance
     */
    private $performance;

    /**
     * @return Performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * @param Performance $performance
     */
    public function setPerformance(Performance $performance)
    {
        $this->performance = $performance;
    }


}