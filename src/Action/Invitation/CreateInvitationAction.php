<?php

namespace App\Action\Invitation;

use App\Domain\Invitation\Service\CreateInvitationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateInvitationAction
{
    /**
     * @var CreateInvitationService
     */
    private CreateInvitationService $service;

    /**
     * @param CreateInvitationService $service
     */
    public function __construct(CreateInvitationService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        //Get Data
        $data = $request->getParsedBody();
        //TODO:Invoke
        $result = $this->service->createInvitation($args['id'], $data);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}