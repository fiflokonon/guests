<?php

namespace App\Domain\File\Service;

use App\Domain\File\Repository\FileRepository;

final class EventFilesService
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
     * @return array|false
     */
    public function getEventFiles(int $id)
    {
        return $this->repository->eventFiles($id);
    }
}