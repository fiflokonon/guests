<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class UserPhotosService
{
    /**
     * @var PhotoRepository
     */
    private PhotoRepository $repository;

    /**
     * @param PhotoRepository $repository
     */
    public function __construct(PhotoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function userPhotos(int $id)
    {
        return $this->repository->getForUser($id);
    }
}