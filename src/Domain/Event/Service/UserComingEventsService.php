<?php

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;

final class UserComingEventsService
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
     * @return array|false
     */
    public function userComings(int $id)
    {
        return $this->repository->userComingEvents($id);
    }
}