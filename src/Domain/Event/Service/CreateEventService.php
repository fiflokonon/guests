<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class CreateEventService
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
     * @param array $event
     * @return false|mixed|string
     */
    public function createEvent(int $id, array $event)
    {
        return $this->repository->creerEvenement($id, $event);
    }
}