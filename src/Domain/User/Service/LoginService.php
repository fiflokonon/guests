<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class LoginService
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
     * @param array $user
     * @return string[]
     */
    public function login(array $user)
    {
        return $this->repository->connexion($user);
    }
}