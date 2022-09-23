<?php

namespace App\Action\User;

use App\Domain\User\Service\DeleteUserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteUserAction
{
    /**
     * @var DeleteUserService
     */
    private DeleteUserService $service;

    /**
     * @param DeleteUserService $service
     */
    public function __construct(DeleteUserService $service)
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
        //TODO: invoke()
        $result = $this->service->deleteUser($args['id']);

        //Build HTTPResponse
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}