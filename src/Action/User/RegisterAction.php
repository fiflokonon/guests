<?php

namespace App\Action\User;

use App\Domain\User\Service\RegisterService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RegisterAction
{
    /**
     * @var RegisterService
     */
    private RegisterService $service;

    /**
     * @param RegisterService $service
     */
    public function __construct(RegisterService $service)
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
        //Get user input
        $data = (array)$request->getParsedBody();
        //TODO: Invoke
        $result = $this->service->register($data);

        // Build the HTTP response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}