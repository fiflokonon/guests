<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class TodayEventsService
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
    public function today()
    {
        return $this->repository->todayEvents();
    }
}