<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\PhotoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PhotoAction
{
    /**
     * @var PhotoService
     */
    private PhotoService $service;

    /**
     * @param PhotoService $service
     */
    public function __construct(PhotoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO:: Invoke()
        $result = $this->service->getPhoto($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}