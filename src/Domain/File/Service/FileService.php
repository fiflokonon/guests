<?php

namespace App\Domain\File\Service;

use App\Domain\File\Repository\FileRepository;

final class FileService
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

    /**
     * @param int $id
     * @return void
     */
    public function getFile(int $id)
    {
        return $this->repository->file($id);
    }
}