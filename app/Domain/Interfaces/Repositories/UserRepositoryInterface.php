<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Models\User;

interface UserRepositoryInterface
{
    public function findByUsername($username): ?User;
}
