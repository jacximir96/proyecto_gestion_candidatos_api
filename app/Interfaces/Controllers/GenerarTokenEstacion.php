<?php

declare(strict_types = 1);

namespace App\Interfaces\Controllers;

use App\Http\Requests\AuthRequest;
use Symfony\Component\HttpFoundation\Response;

interface GenerarTokenEstacion { 
    public function IniciarGenerarTokenEstacionServicioAPI( AuthRequest $request ): Response;
}