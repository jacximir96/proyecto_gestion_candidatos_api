<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Interfaces\Controllers\ControlLeadEstacion as IControlLeadEstacion;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Services\LeadService;
use App\Http\Requests\CreateLeadRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

final class LeadController extends Controller implements IControlLeadEstacion
{
    private $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function IniciarCrearCandidatoEstacionServicioAPI( CreateLeadRequest $request ): Response
    {
        $ipEstacion = $request->ip();

        $this->RegistrarOperacion($ipEstacion, 'crear candidato estacion Servicio API');

        try {
            $lead = $this->leadService->CrearCandidatoEstacionServicioAPI($request->name, $request->source, $request->owner, auth()->id());

            Cache::forget('all_leads');

            $leadArray = $lead->toArray();
    
            $paquete = $this->buildResponse(
                success: true,
                errors: [],
                data: $leadArray
            );
            $statusCode = Response::HTTP_CREATED;
    
        } catch (\Exception $ex) {
            $paquete = $this->buildResponse(
                success: false,
                errors: [$ex->getMessage()]
            );
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $this->RegistrarRespuesta($ipEstacion, $paquete);

        return response()->json($paquete, $statusCode, [], JSON_UNESCAPED_SLASHES);
    }

    public function IniciarObtenerCandidatoEstacionServicioAPI($id): Response
    {
        $ipEstacion = request()->ip();

        $this->RegistrarOperacion($ipEstacion, 'obtener candidato estacion Servicio API');

        try {
            $lead = Cache::remember("lead_{$id}", 600, function () use ($id) {
                return $this->leadService->ObtenerCandidatoPorIdEstacionServicioAPI($id);
            });

            if (!$lead) {
                $paquete = $this->buildResponse(
                    success: false,
                    errors: ['No lead found']
                );
                $statusCode = Response::HTTP_NOT_FOUND;
            } else {
                $paquete = $this->buildResponse(
                    success: true,
                    errors: [],
                    data: $lead->toArray()
                );
                $statusCode = Response::HTTP_OK;
            }
    
        } catch (\Exception $ex) {
            $paquete = $this->buildResponse(
                success: false,
                errors: [$ex->getMessage()]
            );
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
    
        $this->RegistrarRespuesta($ipEstacion, $paquete);
    
        return response()->json($paquete, $statusCode, [], JSON_UNESCAPED_SLASHES);
    }

    public function IniciarObtenerTodosCandidatosEstacionServicioAPI(): Response
    {
        $ipEstacion = request()->ip();

        $this->RegistrarOperacion($ipEstacion, 'obtener todos los candidatos estacion Servicio API');

        try {
            $leadsData = Cache::remember('all_leads', 600, function () {
                return $this->leadService->ObtenerTodosCandidatosEstacionServicioAPI();
            });

            $paquete = $this->buildResponse(
                success: true,
                errors: [],
                data: $leadsData
            );
            $statusCode = Response::HTTP_OK;

        } catch (\Exception $ex) {
            $paquete = $this->buildResponse(
                success: false,
                errors: [$ex->getMessage()]
            );
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
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
