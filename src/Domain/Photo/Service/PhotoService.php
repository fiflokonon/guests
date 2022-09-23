<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class PhotoService
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
     * @return array|mixed
     */
    public function getPhoto(int $id)
    {
        return $this->repository->getPhoto($id);
    }

}