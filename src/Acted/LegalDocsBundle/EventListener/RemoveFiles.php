<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 06.04.16
 * Time: 0:56
 */

namespace Acted\LegalDocsBundle\EventListener;

use Acted\LegalDocsBundle\Entity\Media;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RemoveFiles
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function postRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();


        if (!$entity instanceof Media) {
            return;
        }

        $link = ltrim($entity->getLink(), '/');
        if (($entity->getMediaType() == 'photo') && strpos($link, $this->dir) === 0) {
            unlink($link);
        }

    }

}