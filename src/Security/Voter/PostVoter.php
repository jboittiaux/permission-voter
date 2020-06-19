<?php declare(strict_types=1);

namespace App\Security\Voter;

use App\Interfaces\Post;
use App\Interfaces\User as IUser;
use App\Interfaces\Voter;
use App\Models\User;

class PostVoter implements Voter
{
    const CREATE = 'create_post';
    const EDIT = 'edit_post';

    /**
     * @inheritDoc
     *
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function canVote(string $permission, $subject = null): bool
    {
        if (!in_array($permission, [
            self::EDIT,
            self::CREATE,
        ])) {
            return false;
        }

        if ($subject && !$subject instanceof Post) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     *
     * @param IUser $user
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function vote(IUser $user, string $permission, $subject = null): bool
    {
        if ($subject && !$subject instanceof Post) {
            throw new \RuntimeException('$subject should be an instance of ' . Post::class);
        }

        switch ($permission) {
            case self::CREATE:
                return $user->getProfil() !== User::PROFIL_GUEST;
                break;
            case self::EDIT:
                return $user->getUsername() === $subject->getAuthor()->getUsername();
                break;
        }
    }
}
