<?php

namespace App\Action\File;

use App\Domain\File\Service\DeleteFileService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteFileAction
{
    /**
     * @var DeleteFileService
     */
    private DeleteFileService $service;

    /**
     * @param DeleteFileService $service
     */
    public function __construct(DeleteFileService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO: Implement .
        $result = $this->service->delFile($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}