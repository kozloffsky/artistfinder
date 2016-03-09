<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 09.03.16
 * Time: 17:05
 */

namespace Acted\LegalDocsBundle\Security;


use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;

class AppUserProvider extends EntityUserProvider
{
    public function __construct(ManagerRegistry $registry, $classOrAlias, $property = null, $managerName = null)
    {
        parent::__construct($registry, $classOrAlias, 'email', $managerName);
    }
}