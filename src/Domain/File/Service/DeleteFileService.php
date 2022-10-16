<?php

namespace App\Domain\File\Service;

use App\Domain\File\Repository\FileRepository;

final class DeleteFileService
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
     * @return false|mixed|string
     */
    public function delFile(int $id)
    {
        return $this->repository->supprimerFile($id);
    }
}