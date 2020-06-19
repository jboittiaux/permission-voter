<?php declare(strict_types=1);

namespace App\Interfaces;

interface Post
{
    public function getAuthor(): User;
}
