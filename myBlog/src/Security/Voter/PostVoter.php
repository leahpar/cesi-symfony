<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    public Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_DELETE'])
            && $subject instanceof Post;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Utilisateur non connecté => aucun droit
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Utilisateur ADMIN => Tous les droits
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // Enfin, on regarde droit par droit
        switch ($attribute) {
            case 'POST_EDIT':
            case 'POST_DELETE':
                // autorisé si le post est dans la liste des posts de l'utilisateur
                return $user->getPosts()->contains($subject);
                break;
        }

        // Par défaut, pas le droit
        return false;
    }
}
