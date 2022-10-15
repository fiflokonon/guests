<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class UserTodayEventsService
{
    /**
     * @var EventRepository
     */
    private EventRepository $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function userTodays(int $id)
    {
        return $this->repository->userTodayEvents($id);
    }
}