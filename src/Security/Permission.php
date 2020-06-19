<?php declare(strict_types=1);

namespace App\Security;

use App\Interfaces\User;
use App\Interfaces\Voter;
use App\Security\Voter\AdminVoter;
use App\Security\Voter\PostVoter;

final class Permission
{
    /**
     * @var Voter[]
     */
    private array $voters = [];

    /**
     * Return true if user is allowed to perform an action
     *
     * @param User $user
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function can (User $user, string $permission, $subject = null): bool
    {
        foreach ($this->voters as $voter) {
            if ($voter->canVote($permission, $subject)) {
                $vote = $voter->vote($user, $permission, $subject);

                if ($vote === true) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * addVoter
     *
     * @param Voter $voter
     * @return void
     */
    public function addVoter (Voter $voter): void
    {
        $this->voters[] = $voter;
    }

    /**
     * userCan
     *
     * @param User $user
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public static function userCan(User $user, string $permission, $subject = null): bool
    {
        $perm = new self();

        $perm->addVoter(new AdminVoter());
        $perm->addVoter(new PostVoter());

        return $perm->can($user, $permission, $subject);
    }
}
