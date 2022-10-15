<?php

namespace App\Domain\Invitation\Service;

use App\Domain\Invitation\Repository\InvitationRepository;

final class InvitationsService
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

    /**
     * @return array|false
     */
    public function getInvitations()
    {
        return $this->repository->invitations();
    }
}