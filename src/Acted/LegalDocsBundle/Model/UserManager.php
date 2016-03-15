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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Templating\EngineInterface;

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

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    protected $mailer;

    protected $mailFrom;

    public function __construct(EncoderFactoryInterface $encoderFactory,
                                EntityManagerInterface $entityManagerInterface, $mailer,
                                EngineInterface $templating, UrlGeneratorInterface $router, $mailFrom)
    {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManagerInterface;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->mailFrom = $mailFrom;
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

    public function sendConfirmationEmailMessage(User $user)
    {
        $url = $this->router->generate('security_confirm', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render('@ActedLegalDocs/Security/confirmation.txt.twig', [
            'user' => $user,
            'confirmationUrl' =>  $url
        ]);
        $this->sendEmailMessage($rendered, $this->mailFrom, $user->getEmail());
    }

    protected function generateToken()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
    }

    protected function getRandomNumber()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }

    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $this->mailer->send($message);
    }
}