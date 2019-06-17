<?php

namespace App\Security;

use App\Entity\SubmittedTest;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SubmittedTestVoter extends Voter
{
    const VIEW = 'view';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        // only vote on SubmittedTest objects inside this voter
        if (!$subject instanceof SubmittedTest) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if($user instanceof User) {
            $user_id = $user->getId();
        } else {
            $user_id = null;
        }

        // we know $subject is a SubmittedTest object, thanks to supports
        $submitted_test = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($submitted_test, $user_id);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(SubmittedTest $submitted_test, ?int $user_id)
    {
        $user_who_submitted = $submitted_test->getUserId();

        if ($user_who_submitted) {
            return $user_id === $submitted_test->getUserId()->getId();
        } else {
            return true;
        }
    }
}