<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class UserService
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
     * @return array|false
     */
    public function utilisateur(int $id)
    {
        return $this->repository->user($id);
    }
}