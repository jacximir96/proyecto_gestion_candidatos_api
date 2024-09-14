<?php

declare(strict_types = 1);

namespace App\Interfaces\Controllers;

use App\Http\Requests\CreateLeadRequest;
use Symfony\Component\HttpFoundation\Response;

interface ControlLeadEstacion { 
    public function IniciarCrearCandidatoEstacionServicioAPI( CreateLeadRequest $request ): Response;
    public function IniciarObtenerCandidatoEstacionServicioAPI( ?int $id ): Response;
    public function IniciarObtenerTodosCandidatosEstacionServicioAPI (): Response;
}