<?php

namespace App\Action\Event;

use App\Domain\Event\Service\DeleteEventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteEventAction
{
    /**
     * @var DeleteEventService
     */
    private DeleteEventService $service;

    /**
     * @param DeleteEventService $service
     */
    public function __construct(DeleteEventService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO: Invoke()
        $result = $this->service->deleteEvent($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}