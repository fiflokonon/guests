<?php

namespace App\Action\Event;

use App\Domain\Event\Service\EventsForUserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventsForUserAction
{
    /**
     * @var EventsForUserService
     */
    private EventsForUserService $service;

    /**
     * @param EventsForUserService $service
     */
    public function __construct(EventsForUserService $service)
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
        $result = $this->service->getUserEvents($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

    }
}