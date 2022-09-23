<?php

namespace App\Action\Event;

use App\Domain\Event\Service\EventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventAction
{
    /**
     * @var EventService
     */
    private EventService $service;

    /**
     * @param EventService $service
     */
    public function __construct(EventService $service)
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
        $result = $this->service->getEvent($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}