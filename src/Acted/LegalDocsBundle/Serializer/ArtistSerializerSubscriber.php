<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 19.04.16
 * Time: 1:20
 */

namespace Acted\LegalDocsBundle\Serializer;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\VarDumper\VarDumper;

class ArtistSerializerSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [[
            'event' => 'serializer.post_serialize',
            'method' => 'addMedia',
            'class' => Artist::class
        ],];
    }

    public function addMedia(ObjectEvent $event)
    {
        /** @var Artist $object */
        $object = $event->getObject();
        $data = null;

        /** @var Media $media */
        $media = $this->em->getRepository('ActedLegalDocsBundle:Media')->getLastVideoMedia($object->getUser()->getProfile());

        if ($media) {
            $data = [
                'link' => $media->getLink(),
                'thumbnail' => $media->getThumbnail(),
                'media_type' => $media->getMediaType(),
            ];
        }

        $visitor = $event->getVisitor();
        $visitor->addData('video_media', $data);
    }
}