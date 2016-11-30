<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\Feedback;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Model\UserManager;
use Symfony\Component\Templating\EngineInterface;

class FeedbackManager
{
    protected $entityManager;

    protected $templating;

    /**
     * FeedbackManager constructor.
     * @param EngineInterface $templating
     * @param \Acted\LegalDocsBundle\Model\UserManager $userManager
     */
    public function __construct(EngineInterface $templating, UserManager $userManager)
    {
        $this->templating = $templating;
        $this->userManager = $userManager;
    }

    /**
     * Send notify to Artist about new feedback from Client.
     *
     * @param $client
     * @param $feedback
     */
    public function sendNotify(User $client, Feedback $feedback)
    {
        $template = '@ActedLegalDocs/Email/new_feedback_notify.html.twig';
        $data = ["client" => $client, "feedback" => $feedback];
        $artistEmail = $feedback->getArtist()->getUser()->getEmail();
        $userEmail = $client->getEmail();
        $rendered = $this->templating->render($template, $data);
        $this->userManager->sendEmailMessage($rendered, $userEmail, $artistEmail);
    }

    /**
     * Set feedbacks to viewed
     *
     * @param Feedback $feedbacks
     */
    public function makeViewed(Feedback $feedbacks)
    {
        foreach ($feedbacks as $feedback) {
            $feedback->setViewed(true);
            $this->entityManager->merge($feedback);
            $this->entityManager->flush();
        }
    }
}