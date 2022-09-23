<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class DeleteEventService
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
     * @return mixed
     */
    public function deleteEvent(int $id)
    {
        return $this->repository->supprimerEvenement($id);
    }
}