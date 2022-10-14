<?php

namespace App\Action\Event;

use App\Domain\Event\Service\ComingEventsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ComingEventsAction
{
    /**
     * @var ComingEventsService
     */
    private ComingEventsService $service;

    /**
     * @param ComingEventsService $service
     */
    public function __construct(ComingEventsService $service)
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
        //TODO:Invoke()
        $result = $this->service->coming();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}