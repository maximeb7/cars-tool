<?php

namespace App\Application\Handlers\RepairTypes;

use App\Domain\Repositories\RepairTypesRepositoryInterface;

class GetRepairTypesHandler
{
    private RepairTypesRepositoryInterface $repairTypesRepository;

    public function __construct(
        RepairTypesRepositoryInterface $repairTypesRepository
    )
    {
        $this->repairTypesRepository = $repairTypesRepository;
    }

    public function handle(): ?array
    {
        return $this->repairTypesRepository->getAll();
    }
}
