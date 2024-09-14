<?php 

declare(strict_types = 1);

namespace App\Interfaces\UseCases;

interface GenerarTokenEstacion {
    public function AutenticarTokenEstacionServicioAPI( ?string $username, ?string $password ): string;
}