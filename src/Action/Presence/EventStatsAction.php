<?php

namespace App\Action\Presence;

use App\Domain\Presence\Service\EventStatsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventStatsAction
{
    /**
     * @var EventStatsService
     */
    private EventStatsService $service;

    /**
     * @param EventStatsService $service
     */
    public function __construct(EventStatsService $service)
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
        $result = $this->service->getStats($args['id']);
        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}