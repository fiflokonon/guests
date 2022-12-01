<?php

namespace App\Domain\Presence\Service;

use App\Domain\Presence\Repository\PresenceRepository;

final class EventStatsService
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

    /**
     * @param int $id
     * @return int|mixed
     */
    public function getStats(int $id)
    {
        return $this->repository->eventStats($id);
    }
}