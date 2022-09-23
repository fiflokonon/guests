<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class RegisterService
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
     * @param $user
     * @return array
     */
    public function register($user): array
    {
        return $this->repository->inscription($user);
    }
}