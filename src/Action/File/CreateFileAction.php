<?php

namespace App\Action\File;

use App\Domain\File\Service\CreateFileService;

final class CreateFileAction
{
    /**
     * @var CreateFileService
     */
    private CreateFileService $service;

    /**
     * @param CreateFileService $service
     */
    public function __construct(CreateFileService $service)
    {
        $this->service = $service;
    }
}