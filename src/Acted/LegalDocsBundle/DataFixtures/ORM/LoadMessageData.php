<?php

namespace Acted\LegalDocsBundle\DataFixtures\ORM;

use Acted\LegalDocsBundle\Entity\Message;
use Acted\LegalDocsBundle\Entity\ChatRoom;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $now = new \DateTime();
        for( $i = 0; $i < 3; $i++) {
            $chatRoom = new ChatRoom();
            $chatRoom->setUser($this->getReference('user2'));
            $chatRoom->setEvent($this->getReference('event1_'.$i));
            $chatRoom->setOffer($this->getReference('offer_'. ($i+1)*10));
            for ($n = 1; $n <= 10; $n++) {
                $message = new Message();
                $message->setMessageText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis velit ut ex sollicitudin, pretium varius magna accumsan. Curabitur orci justo, mollis a sollicitudin eu, congue at enim. Aenean molestie suscipit mauris vitae luctus. Duis faucibus dolor nibh, quis pulvinar magna pulvinar eget. Aliquam non felis quam. Curabitur finibus libero nunc, ut placerat lorem ultrices maximus. Donec condimentum nunc eu augue pulvinar, a tincidunt lorem faucibus');
                $message->setSendDateTime($now);
                $message->setSubject('Test subject '. $n);
                $message->setChatRoom($chatRoom);
                $message->setReceiverUser($this->getReference('user2'));
                $message->setSenderUser($this->getReference('user1'));
                $manager->persist($message);
            }
            $manager->persist($chatRoom);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}