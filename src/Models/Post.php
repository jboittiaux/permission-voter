<?php declare(strict_types=1);

namespace App\Models;

use App\Interfaces\Post as IPost;
use App\Interfaces\User;

class Post implements IPost
{
    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAuthor(): User
    {
        return $this->user;
    }
}
