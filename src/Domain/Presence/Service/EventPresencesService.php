<?php

namespace App\Domain\Presence\Service;

use App\Domain\Presence\Repository\PresenceRepository;

final class EventPresencesService
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

    public function eventPres(int $id)
    {
        return $this->repository->getPresencesEvent($id);
    }
}