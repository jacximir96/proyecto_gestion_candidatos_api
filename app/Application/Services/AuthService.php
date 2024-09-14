<?php

namespace App\Application\Services;

use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\UseCases\GenerarTokenEstacion as IGenerarTokenEstacion;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

final class AuthService implements IGenerarTokenEstacion
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function AutenticarTokenEstacionServicioAPI($username, $password): string
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user) {
            throw new \Exception("User not found: " . $username);
        }

        if ($user && Hash::check($password, $user->getPassword())) {
            if ($user->id) {
                return JWTAuth::fromUser($user);
            }

            throw new \Exception("User ID is invalid.");
        }

        throw new \Exception("Password incorrect for: " . $username);
    }
}
