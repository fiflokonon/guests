<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class DeletePhotoService
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
     * @return void
     */
    public function deletePhoto(int $id)
    {
        return $this->repository->supprimerPhoto($id);
    }
}