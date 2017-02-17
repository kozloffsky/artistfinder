<?php
/**
 * Created by PhpStorm.
 * User: kozlo
 * Date: 2/16/2017
 * Time: 3:09 PM
 */

namespace Acted\LegalDocsBundle\EventListener;


use Acted\LegalDocsBundle\Entity\Performance;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PerformancePrePersistListener
{
    public function prePersist(LifecycleEventArgs $args){
        $performance = $args->getEntity();
        if ($performance instanceof Performance) {
            $this->validatePerformance($performance);
        }
    }

    protected function validatePerformance(Performance $performance){
        $performance->setStatus(Performance::STATUS_DRAFT);
        if (strlen($performance->getTitle()) < 4) return false;

        //TODO: Here is actual description! so we check this. needs to be refactored
        if (strlen($performance->getTechRequirement()) < 10) return false;

        if($performance->getMedia()->count() < 2) return false;

        $performance->setStatus(Performance::STATUS_PUBLISHED);
    }
}