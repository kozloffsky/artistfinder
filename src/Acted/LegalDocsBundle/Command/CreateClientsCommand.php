<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/12/16
 * Time: 10:54
 */

namespace Acted\LegalDocsBundle\Command;


use Acted\LegalDocsBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientsCommand extends ContainerAwareCommand
{


    protected function configure(){
        $this->setName('create:clients')
            ->setDescription('Create client entities for users with role ROLE_CLIENT ');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $res = $em->getRepository('ActedLegalDocsBundle:User')->createQueryBuilder('u')
            ->leftJoin('u.roles','role')
            ->where('role.code = :role')
            ->setParameter('role','ROLE_CLIENT')
            ->getQuery()->getResult();

        foreach($res as $user){
            $c = new Client();
            $c->setClientType('Client');
            $c->setCompany('');
            $c->setComments('');
            $c->setAddress('');
            $c->setCityId(1);
            $c->setUser($user);
            $em->persist($c);
        }

        $em->flush();
    }

}