<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class EditUserService
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
     * @param array $user
     * @return false|mixed|string|null
     */
    public function updateUser(int $id, array $user)
    {
        return $this->repository->editUtilisateur($id, $user);
    }

}