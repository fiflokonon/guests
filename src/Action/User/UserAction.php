<?php

namespace App\Action\User;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserAction
{
    /**
     * @var UserService
     */
    private UserService $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
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

        //Invoke
        $result = $this->service->utilisateur((int)($args['id']));
        //Build a response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}