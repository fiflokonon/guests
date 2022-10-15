<?php

namespace App\Action\Invitation;

use App\Domain\Invitation\Service\InvitationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class InvitationAction
{
    /**
     * @var InvitationService
     */
    private InvitationService $service;

    /**
     * @param InvitationService $service
     */
    public function __construct(InvitationService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //TODO:Invoke()
        $result = $this->service->getInvitation($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}