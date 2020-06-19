<?php declare(strict_types=1);

namespace App\Interfaces;

interface User
{
    public function getUsername(): string;

    public function getProfil(): string;
}
