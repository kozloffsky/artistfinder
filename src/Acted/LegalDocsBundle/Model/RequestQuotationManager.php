<?php

namespace Acted\LegalDocsBundle\Model;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Model\UserManager;

class RequestQuotationManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    protected $mailer;

    protected $mailFrom;

    /**
     * @var EngineInterface
     */
    protected $templating;

    protected $userManager;


    /**
     * RequestQuotationManager constructor.
     * @param EntityManagerInterface $entityManagerInterface
     * @param $mailer
     * @param $mailFrom
     * @param EngineInterface $templating
     * @param \Acted\LegalDocsBundle\Model\UserManager $userManager
     */
    public function __construct(EntityManagerInterface $entityManagerInterface, $mailer, $mailFrom, EngineInterface $templating, UserManager $userManager)
    {
        $this->entityManager = $entityManagerInterface;
        $this->mailer = $mailer;
        $this->mailFrom = $mailFrom;
        $this->templating = $templating;
        $this->userManager = $userManager;
    }

    /**
     * Send notify to Customer about Quotation reply
     * @param $eventData
     * @param $artist
     * @param bool $edited
     */
    public function sendNotify($eventData, $artist, $client, $quotationLink, $edited = false)
    {
        $template = '@ActedLegalDocs/Email/quotation_reply_notify.html.twig';
        if ($edited) {
            $template = '@ActedLegalDocs/Email/quotation_edited_notify.html.twig';
        }
        $rendered = $this->templating->render($template, [
            'event' => $eventData,
            'user' => $artist,
            'client' => $client,
            'quotationLink' => $quotationLink
        ]);

        $this->userManager->sendEmailMessage($rendered, $artist->getEmail(), $client->getEmail());
    }
}