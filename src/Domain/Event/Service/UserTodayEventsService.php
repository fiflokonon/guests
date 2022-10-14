<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class UserTodayEventsService
{
    /**
     * @var EventRepository
     */
    private EventRepository $repository;

    /**
     * @param EventRepository $repository
     */
    private function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function userTodays(int $id)
    {
        return $this->repository->userTodayEvents($id);
    }
}