<?php

namespace App\Action\Event;

use App\Domain\Event\Service\UserPastEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserPastEventsAction
{
    /**
     * @var UserPastEventsService
     */
    private UserPastEventsService $service;

    /**
     * @param UserPastEventsService $service
     */
    public function __construct(UserPastEventsService $service)
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
        //TODO:Invoke()
        $result = $this->service->userPasts($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}