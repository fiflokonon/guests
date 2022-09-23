<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class ChangeStatusService
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return false|mixed|string|null
     */
    public function changeStatus(int $id)
    {
        return $this->repository->changerStatutUtilisateur($id);
    }
}