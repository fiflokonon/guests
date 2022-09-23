<?php

namespace App\Action\User;

use App\Domain\User\Service\EditUserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditUserAction
{
    /**
     * @var EditUserService
     */
    private EditUserService $service;

    /**
     * @param EditUserService $service
     */
    public function __construct(EditUserService $service)
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
        //TODO: Get Data To UPDATE
        $data = $request->getParsedBody();
        //TODO: invoke()
        $result = $this->service->updateUser($args['id'], $data);
        //TODO: Build HttResponse
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}