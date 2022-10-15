<?php

namespace App\Action\Invitation;

use App\Domain\Invitation\Service\EventInvitationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EventInvitationsAction
{
    /**
     * @var EventInvitationsService
     */
    private EventInvitationsService $service;

    /**
     * @param EventInvitationsService $service
     */
    public function __construct(EventInvitationsService $service)
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
        $result = $this->service->getEventInvitations($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}