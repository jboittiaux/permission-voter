<?php declare(strict_types=1);

namespace App\Models;

use App\Interfaces\User as IUser;

class User implements IUser
{
    const PROFIL_GUEST = 'guest';
    const PROFIL_USER = 'user';
    const PROFIL_ADMIN = 'admin';

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $profil;

    public function __construct(string $username, string $profil = self::PROFIL_GUEST)
    {
        $this->username = $username;
        $this->profil = $profil;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getProfil(): string
    {
        return $this->profil;
    }
}
