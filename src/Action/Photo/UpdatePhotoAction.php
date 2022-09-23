<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\UpdatePhotoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdatePhotoAction
{
    /**
     * @var UpdatePhotoService
     */
    private UpdatePhotoService $service;

    /**
     * @param UpdatePhotoService $service
     */
    public function __construct(UpdatePhotoService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        // TODO:: Invoke()
        $data = $request->getParsedBody();
        $result = $this->service->updatePhoto($args['id'], $data['lien']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}