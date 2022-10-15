<?php

namespace App\Action\Invitation;

use App\Domain\Invitation\Service\InvitationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class InvitationsAction
{
    /**
     * @var InvitationsService
     */
    private InvitationsService $service;

    public function __construct(InvitationsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        //TODO:Invoke
        $result = $this->service->getInvitations();

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}