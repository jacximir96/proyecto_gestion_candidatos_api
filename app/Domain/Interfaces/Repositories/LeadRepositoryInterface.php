<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Models\Lead;

interface LeadRepositoryInterface
{
    public function findById($id): ?Lead;
    public function findAll(): array;
    public function create($name, $source, $ownerId, $createdById): Lead;
}
