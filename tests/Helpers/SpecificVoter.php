<?php declare(strict_types=1);

namespace Tests\Helpers;

use App\Interfaces\User;
use App\Interfaces\Voter;

class SpecificVoter implements Voter
{
    public function canVote (string $permission, $subject = null): bool
    {
        return $permission === 'specific';
    }

    public function vote (User $user, string $permission, $subject = null): bool
    {
        return true;
    }
}
