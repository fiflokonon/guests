<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class EventsService
{
    private EventRepository $repository;

    /**
     * @param EventRepository $repository
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array|false
     */
    public function getEventsList()
    {
        return $this->repository->listEvenements();
    }
}