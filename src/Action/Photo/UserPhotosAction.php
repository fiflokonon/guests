<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\UserPhotosService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserPhotosAction
{
    /**
     * @var UserPhotosService
     */
    private UserPhotosService $service;

    /**
     * @param UserPhotosService $service
     */
    public function __construct(UserPhotosService $service)
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
        //TODO: Invoke()
        $result = $this->service->userPhotos($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}