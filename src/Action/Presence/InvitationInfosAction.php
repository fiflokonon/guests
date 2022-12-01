<?php

namespace App\Action\Presence;

use App\Domain\Presence\Service\InvitationInfosService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class InvitationInfosAction
{
    /**
     * @var InvitationInfosService
     */
    private InvitationInfosService $service;

    /**
     * @param InvitationInfosService $service
     */
    public function __construct(InvitationInfosService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        #$data = $request->getParsedBody();
        $result = $this->service->invitInfos($args['encrypted']);
        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}