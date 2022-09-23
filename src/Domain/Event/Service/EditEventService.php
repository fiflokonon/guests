<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class EditEventService
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
    public function editEvent(int $id, array $event)
    {
        return $this->repository->editEvenement($id, $event);
    }
}