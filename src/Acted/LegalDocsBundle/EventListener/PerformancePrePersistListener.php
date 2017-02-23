<?php
/**
 * Created by PhpStorm.
 * User: kozlo
 * Date: 2/16/2017
 * Time: 3:09 PM
 */

namespace Acted\LegalDocsBundle\EventListener;


use Acted\LegalDocsBundle\Entity\Performance;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Monolog\Logger;

class PerformancePrePersistListener
{
    /**
     * @var Logger
     */
    private $log;

    public function __construct($log)
    {
        $this->log = $log;
    }

    public function postPersist(LifecycleEventArgs $args){
        $performance = $args->getEntity();
        $manager = $args->getEntityManager();
        $this->log->info('on event');
        if ($performance instanceof Performance) {
            $this->validatePerformance($performance, $manager);
        }
    }

    protected function validatePerformance(Performance $performance, EntityManager $entityManager){
        $performance->setStatus(Performance::STATUS_DRAFT);
        //if (strlen($performance->getTitle()) < 4) return false;

        //TODO: Here is actual description! so we check this. needs to be refactored
        //if (strlen($performance->getTechRequirement()) < 10) return false;

        //if($performance->getMedia()->count() < 2) return false;

        $performance->setStatus(Performance::STATUS_PUBLISHED);

        $entityManager->persist($performance);
        $entityManager->flush();
    }
}