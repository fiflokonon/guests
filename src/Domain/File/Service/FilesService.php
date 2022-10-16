<?php

namespace App\Domain\File\Service;

use App\Domain\File\Repository\FileRepository;

final class FilesService
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
     * @return array|false
     */
    public function getFiles()
    {
        return $this->repository->files();
    }
}