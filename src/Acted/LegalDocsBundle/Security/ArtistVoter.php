<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 25.03.16
 * Time: 11:56
 */

namespace Acted\LegalDocsBundle\Security;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArtistVoter extends Voter
{
    const EDIT = 'EDIT';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Artist) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Artist $profile */
        $profile = $subject;

        switch($attribute) {
            case self::EDIT:
                return $this->canEdit($profile, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Artist $artist, User $user)
    {
        return $user === $artist->getUser();
    }
}