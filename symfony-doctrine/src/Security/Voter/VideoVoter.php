<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class VideoVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['VIDEO_DELETE', 'VIDEO_VIEW'])
            && $subject instanceof \App\Entity\Video;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $video = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'VIDEO_DELETE':
                // logic to determine if the user can DELETE
                // return true or false
                return $user === $video->getSecurityUser();
                break;
            case 'VIDEO_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                return $user === $video->getSecurityUser();
                break;
        }

        return false;
    }
}
