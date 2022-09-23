<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

final class GetMeService
{
    private  UserRepository $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function returnMe(string $token)
    {
        return $this->repository->getMe($token);
    }
}