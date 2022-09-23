<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class UsersService
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @return array
     */
    public function getUsers():array
    {
        return $this->repository->getUsers();
    }
}