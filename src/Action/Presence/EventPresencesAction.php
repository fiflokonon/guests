<?php

namespace App\Action\Presence;

use App\Domain\Presence\Service\EventPresencesService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventPresencesAction
{
    /**
     * @var EventPresencesService
     */
    private EventPresencesService $service;

    /**
     * @param EventPresencesService $service
     */
    public function __construct(EventPresencesService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        // TODO: Implement __invoke() method.
        $result = $this->service->eventPres($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}