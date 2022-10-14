<?php

namespace App\Action\Event;

use App\Domain\Event\Service\UserComingEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserComingEventsAction
{
    /**
     * @var UserComingEventsService
     */
    private UserComingEventsService $service;

    /**
     * @param UserComingEventsService $service
     */
    public function __construct(UserComingEventsService $service)
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
        //TODO: Invoke()
        $result = $this->service->userComings($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}