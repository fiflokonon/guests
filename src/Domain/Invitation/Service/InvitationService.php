<?php

namespace App\Domain\Invitation\Service;

use App\Domain\Invitation\Repository\InvitationRepository;

final class InvitationService
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
     * @param int $id
     * @return array|mixed
     */
    public function getInvitation(int $id)
    {
        return $this->repository->invitation($id);
    }
}