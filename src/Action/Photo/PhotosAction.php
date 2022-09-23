<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\PhotosService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PhotosAction
{
    /**
     * @var PhotosService
     */
    private PhotosService $service;

    /**
     * @param PhotosService $service
     */
    public function __construct(PhotosService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        //TODO: Invoke()
        $result = $this->service->photos();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}