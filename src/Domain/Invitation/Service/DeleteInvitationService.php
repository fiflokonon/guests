<?php

namespace App\Domain\Invitation\Service;

use App\Domain\Invitation\Repository\InvitationRepository;

final class DeleteInvitationService
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
     * @return false|mixed|string
     */
    public function delInvitation(int $id)
    {
        return $this->repository->supprimerInvitation($id);
    }
}