<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class UpdatePhotoService
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
     * @param string $lien
     * @return false|mixed|string
     */
    public function updatePhoto(int $id, string $lien)
    {
        return $this->repository->editPhoto($id, $lien);
    }
}