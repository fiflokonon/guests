<?php

namespace App\Domain\Invitation\Service;

use App\Domain\Invitation\Repository\InvitationRepository;

final class EventInvitationsService
{
    /**
     * @var InvitationRepository
     */
    private InvitationRepository $repository;
    /**
     * @param InvitationRepository $repository
     */
    public function __construct(InvitationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getEventInvitations(int $id)
    {
        return $this->repository->eventInvitations($id);
    }
}