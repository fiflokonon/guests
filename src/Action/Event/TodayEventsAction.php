<?php

namespace App\Action\Event;

use App\Domain\Event\Service\TodayEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TodayEventsAction
{
    /**
     * @var TodayEventsService
     */
    private TodayEventsService $service;

    /**
     * @param TodayEventsService $service
     */
    public function __construct(TodayEventsService $service)
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
        //TODO::Invoke
        $result = $this->service->today();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}