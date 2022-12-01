<?php

namespace App\Domain\Presence\Service;

use App\Domain\Presence\Repository\PresenceRepository;

final class InvitationInfosService
{
    /**
     * @var PresenceRepository
     */
    private PresenceRepository $repository;

    /**
     * @param PresenceRepository $repository
     */
    public function __construct(PresenceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return array
     */
    public function invitInfos(string $invit_crypt)
    {
        $id = $this->repository->aesDecrypt($invit_crypt);
        return $this->repository->invitationInfos(intval($id));
    }
}