<?php declare(strict_types=1);

namespace App\Interfaces;

interface Voter
{
    /**
     * Definit si le voter a le droit de vote en fonction d'un contexte donne
     *
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function canVote (string $permission, $subject = null): bool;

    /**
     * Logique de vote du voter
     *
     * @param User $user
     * @param string $permission
     * @param $subject
     * @return boolean
     */
    public function vote (User $user, string $permission, $subject = null): bool;
}
