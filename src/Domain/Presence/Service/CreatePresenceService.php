<?php

namespace App\Domain\Presence\Service;

use App\Domain\Presence\Repository\PresenceRepository;

final class CreatePresenceService
{
    /**
     * @var PresenceRepository
     */
    private PresenceRepository $repository;

    /**
     * @param PresenceRepository $repository
     */
    public function __construct(PresenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createPres(int $id, int $place)
    {
        return $this->repository->createPresence($id, $place);
    }
}