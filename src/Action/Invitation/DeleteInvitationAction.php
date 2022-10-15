<?php

namespace App\Action\Invitation;

use App\Domain\Invitation\Service\DeleteInvitationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteInvitationAction
{
    /**
     * @var DeleteInvitationService
     */
    private DeleteInvitationService $service;

    /**
     * @param DeleteInvitationService $service
     */
    public function __construct(DeleteInvitationService $service)
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
        $result = $this->service->delInvitation($args['id']);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}