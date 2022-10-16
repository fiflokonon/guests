<?php

namespace App\Domain\File\Service;

use App\Domain\File\Repository\FileRepository;

final class CreateFileService
{
    /**
     * @var FileRepository
     */
    private FileRepository $repository;

    /**
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addFile(int $id, string $lien)
    {
        return $this->repository->createFile($id, $lien);
    }
}