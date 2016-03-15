<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 14.03.16
 * Time: 19:12
 */

namespace Acted\LegalDocsBundle\Model;


use Acted\LegalDocsBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EncoderFactoryInterface $encoderFactory, EntityManagerInterface $entityManagerInterface)
    {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManagerInterface;
    }

    public function newUser($firstName, $lastName, $email, $plainPassword, $roleCode)
    {
        $user = new User();
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setEmail($email);

        $role = $this->entityManager->getRepository('ActedLegalDocsBundle:RefRole')->findOneByCode($roleCode);

        if(!$role) {
            throw new \InvalidArgumentException();
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $user->setPasswordHash($encoder->encodePassword($plainPassword, $user->getSalt()));

        $user->setConfirmationToken($this->generateToken());
        $user->addRole($role);

        return $user;
    }

    private function generateToken()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
    }

    private function getRandomNumber()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }


}