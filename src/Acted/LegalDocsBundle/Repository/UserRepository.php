<?php

namespace Acted\LegalDocsBundle\Repository;
use Acted\LegalDocsBundle\Entity\RefRole;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string $query
     * @param string $role
     * @param integer $curUserId
     * @param string $fake
     * @param int $userId
     * @return \Doctrine\ORM\Query
     */
    public function getUsersList($query, $role, $curUserId, $fake, $userId)
    {
        $qb =  $this
            ->createQueryBuilder('u')
            ->leftJoin('u.artist', 'a')
            ->where('u.id != :curUserId')
            ->setParameter('curUserId', $curUserId)
            ->orderBy('u.id', 'ASC');

        if ($query) {
            $qb
                ->andWhere('(MATCH(a.name, a.assistantName) AGAINST (:query BOOLEAN) > 0
                            OR MATCH(u.firstname, u.lastname) AGAINST (:query BOOLEAN) > 0)
                ')
                ->setParameter('query', $query);
        }
        switch ($fake) {
            case 'isFake':
                $qb->andWhere('u.fake = 1');
                break;
            case 'notFake':
                $qb->andWhere('u.fake = 0');
                break;
            default:
                break;
        }
        switch ($role) {
            case 'client':
                $qb
                    ->leftJoin('u.roles', 'r')
                    ->andWhere('r.code = :code')
                    ->setParameter('code', 'ROLE_CLIENT');
                break;
            case 'artist':
                $qb
                    ->leftJoin('u.roles', 'r')
                    ->andWhere('r.code = :code')
                    ->setParameter('code', 'ROLE_ARTIST');
                break;
            case 'admin':
                $qb
                    ->leftJoin('u.roles', 'r')
                    ->andWhere('r.code = :code')
                    ->setParameter('code', 'ROLE_ADMIN');
                break;
            default:
                break;
        }

        if ($userId) {
           $qb
               ->andWhere('u.id = :userId')
               ->setParameter('userId', $userId)
           ;
        }

        return $qb->getQuery();
    }
}
