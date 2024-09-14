<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Interfaces\Controllers\GenerarTokenEstacion as IGenerarTokenEstacion;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;

final class GenerarTokenEstacion extends Controller implements IGenerarTokenEstacion
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function IniciarGenerarTokenEstacionServicioAPI( AuthRequest $request ): Response {
        $ipEstacion = $request->ip();

        $this->RegistrarOperacion($ipEstacion, 'generar token estacion Servicio API');

        try {
            $token = $this->authService->AutenticarTokenEstacionServicioAPI($request->username, $request->password);

            $paquete = $this->buildResponse(
                success: true, 
                errors: [], 
                data: ['token' => $token, 'minutes_to_expire' => (int) env('TOKEN_EXPIRATION_MINUTES', 1440)]
            );
            $statusCode = Response::HTTP_OK;

        } catch (\Exception $ex) {
            $paquete = $this->buildResponse(
                success: false, 
                errors: [$ex->getMessage()]
            );
            $statusCode = Response::HTTP_UNAUTHORIZED;
        }

        $this->RegistrarRespuesta($ipEstacion, $paquete);

        return response()->json($paquete, $statusCode, [], JSON_UNESCAPED_SLASHES);
    }
    private function buildResponse(bool $success, array $errors = [], ?array $data = null): array
    {
        $response = [
            'meta' => [
                'success' => $success,
                'errors' => $errors
            ]
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return $response;
    }
}
