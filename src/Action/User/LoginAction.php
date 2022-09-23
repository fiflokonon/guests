<?php

namespace App\Action\User;

use App\Domain\User\Service\LoginService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginAction
{
    /**
     * @var LoginService
     */
    private LoginService $service;

    /**
     * @param LoginService $service
     */
    public function __construct(LoginService $service)
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
    ):ResponseInterface
    {
        //Get User Infos
        $data = $request->getParsedBody();

        //Invoke
        $result = $this->service->login($data);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}