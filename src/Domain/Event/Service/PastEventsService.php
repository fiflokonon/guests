<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class PastEventsService
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
     * @return array|false
     */
    public function past()
    {
        return $this->repository->pastEvents();
    }
}