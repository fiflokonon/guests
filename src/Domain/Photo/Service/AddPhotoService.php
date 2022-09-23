<?php

namespace App\Domain\Photo\Service;

use App\Domain\Photo\Repository\PhotoRepository;

final class AddPhotoService
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
        return $this->repository = $repository;
    }

    /**
     * @param int $id
     * @param string $lien
     * @return void
     */
    public function createPhoto(int $id, string $lien): void
    {
        $this->repository->photo($id, $lien);
    }
}