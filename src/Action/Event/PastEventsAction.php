<?php

namespace App\Action\Event;

use App\Domain\Event\Service\PastEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PastEventsAction
{
    /**
     * @var PastEventsService
     */
    private PastEventsService $service;

    /**
     * @param PastEventsService $service
     */
    public function __construct(PastEventsService $service)
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
        //TODO:Invoke
        $result = $this->service->past();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}