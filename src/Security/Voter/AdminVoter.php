<?php declare(strict_types=1);

namespace App\Security\Voter;

use App\Interfaces\User;
use App\Interfaces\Voter;

class AdminVoter implements Voter
{
    const ADMIN = 'admin';

    /**
     * @inheritDoc
     *
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function canVote(string $permission, $subject = null): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     *
     * @param User $user
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function vote(User $user, string $permission, $subject = null): bool
    {
        return $user->getProfil() === 'admin';
    }
}
