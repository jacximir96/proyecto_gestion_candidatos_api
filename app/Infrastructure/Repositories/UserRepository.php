<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\User;
use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User as EloquentUser;

class UserRepository implements UserRepositoryInterface
{
    public function findByUsername($username): ?User
    {
        $eloquentUser = EloquentUser::where('username', $username)->first();

        if (!$eloquentUser) {
            return null;
        }

        return new User([
            'id' => $eloquentUser->id,
            'username' => $eloquentUser->username,
            'password' => $eloquentUser->password,
            'role' => $eloquentUser->role,
            'is_active' => $eloquentUser->is_active,
        ]);
    }

    public function save(User $user): void
    {
        $eloquentUser = new EloquentUser();
        $eloquentUser->username = $user->getUsername();
        $eloquentUser->password = bcrypt($user->getPassword());
        $eloquentUser->role = $user->getRole();
        $eloquentUser->is_active = $user->isActive();
        $eloquentUser->save();
    }
}
