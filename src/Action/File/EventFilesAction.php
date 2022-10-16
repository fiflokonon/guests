<?php

namespace App\Action\File;

use App\Domain\File\Service\EventFilesService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventFilesAction
{
    /**
     * @var EventFilesService
     */
    private EventFilesService $service;

    /**
     * @param EventFilesService $service
     */
    public function __construct(EventFilesService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO: Implement.
        $result = $this->service->getEventFiles($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}