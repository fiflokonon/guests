<?php

namespace App\Action\User;

use App\Domain\User\Service\UsersService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsersAction
{
    /**
     * @var UsersService
     */
    private UsersService $service;

    /**
     * @param UsersService $service
     */
    public function __construct(UsersService $service)
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
        //Invoke
        $result = $this->service->getUsers();
        //Build Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}