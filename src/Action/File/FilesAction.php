<?php

namespace App\Action\File;

use App\Domain\File\Service\FilesService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilesAction
{
    /**
     * @var FilesService
     */
    private FilesService $service;

    public function __construct(FilesService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        //TODO:Invoke
        $result = $this->service->getFiles();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}