<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class EventService
{
    /**
     * @var EventRepository
     */
    private EventRepository $repository;

    /**
     * @param EventRepository $repository
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function getEvent(int $id)
    {
        return $this->repository->event($id);
    }
}