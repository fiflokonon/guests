<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\DeletePhotoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeletePhotoAction
{
    /**
     * @var DeletePhotoService
     */
    private DeletePhotoService $service;

    /**
     * @param DeletePhotoService $service
     */
    public function __construct(DeletePhotoService $service)
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
        // TODO: Implement __invoke() method.
        $result = $this->service->deletePhoto($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}