<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Lead;
use App\Domain\Interfaces\Repositories\LeadRepositoryInterface;

class LeadRepository implements LeadRepositoryInterface
{
    public function findById($id): ?Lead
    {
        return Lead::find($id);
    }

    public function findAll(): array
    {
        return Lead::all()->toArray();
    }

    public function create($name, $source, $ownerId, $createdById): Lead
    {
        $existingLead = Lead::where('name', $name)->first();

        if ($existingLead) {
            throw new \Exception('A lead with this name already exists.');
        }

        return Lead::create([
            'name' => $name,
            'source' => $source,
            'owner' => $ownerId,
            'created_by' => $createdById,
        ]);
    }
}
