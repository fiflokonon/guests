<?php

namespace App\Action\Event;

use App\Domain\Event\Service\UserTodayEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserTodayEventsAction
{
    /**
     * @var UserTodayEventsService
     */
    private UserTodayEventsService $service;

    /**
     * @param UserTodayEventsService $service
     */
    public function __construct(UserTodayEventsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO:Invoke
        $result = $this->service->userTodays($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}