<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 17:10
 */

namespace Acted\LegalDocsBundle\Search;


class OrderCriteria
{
    const TOP_RATED = 'top_rated';
    const LOWEST_RATED = 'lowest_rated';
    const CHEAPEST = 'cheapest';
    const MORE_EXPENSIVE = 'more_expensive';

    protected $rating = self::TOP_RATED;
    protected $price = self::CHEAPEST;
    protected $prioritized = 'rating';

    public function __construct($rating = self::TOP_RATED, $price = self::CHEAPEST, $prioritized = 'rating')
    {
        switch ($rating) {
            case self::TOP_RATED:
                $this->rating = 'DESC';
                break;
            case self::LOWEST_RATED:
                $this->rating = 'ASC';
                break;
            default:
                throw new \InvalidArgumentException();
        }

        switch ($price) {
            case self::CHEAPEST:
                $this->price = 'ASC';
                break;
            case self::MORE_EXPENSIVE:
                $this->price = 'DESC';
                break;
            default:
                throw new \InvalidArgumentException();
        }

        $this->prioritized = $prioritized;
    }

    public function getRatingOrder()
    {
        return $this->rating;
    }

    public function getPriceOrder()
    {
        return $this->price;
    }

    public function getPrioritized()
    {
        return $this->prioritized;
    }
}
