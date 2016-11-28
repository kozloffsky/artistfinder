<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Entity\Feedback;
use Doctrine\ORM\EntityManager;

class FeedbackManager
{
    private $entityManager;

    /**
     * FeedbackManager constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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