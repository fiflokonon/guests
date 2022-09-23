<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class ActivePhotoService
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
     * @return array|false
     */
    public function activePhoto(int $id)
    {
        return $this->repository->getActive($id);
    }
}