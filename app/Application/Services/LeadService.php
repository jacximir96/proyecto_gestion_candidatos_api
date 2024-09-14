<?php

namespace App\Application\Services;

use App\Domain\Interfaces\Repositories\LeadRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LeadService
{
    private $leadRepository;

    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    /* Crear nuevo candidato - Servicio */
    public function CrearCandidatoEstacionServicioAPI(string $name, string $source, int $ownerId, int $createdById)
    {
        try {
            return $this->leadRepository->create($name, $source, $ownerId, $createdById);
        } catch (\Exception $e) {
            throw new \Exception('Error creating lead: ' . $e->getMessage());
        }
    }

    /* Obtener un candidato por ID - Servicio */
    public function ObtenerCandidatoPorIdEstacionServicioAPI($id)
    {
        $lead = $this->leadRepository->findById($id);

        if (!$lead) {
            throw new ModelNotFoundException("Lead with ID {$id} not found.");
        }
    
        return $lead;
    }

    /* Obtener todos los candidatos - Servicio */
    public function ObtenerTodosCandidatosEstacionServicioAPI(): array
    {
        return $this->leadRepository->findAll();
    }
}
