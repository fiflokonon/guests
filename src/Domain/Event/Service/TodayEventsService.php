<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class TodayEventsService
{
    /**
     * @var EventRepository
     */
    private EventRepository $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getToday()
    {
        return $this->repository->todayEvents();
    }
}