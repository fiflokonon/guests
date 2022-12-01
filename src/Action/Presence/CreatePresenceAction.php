<?php

namespace App\Action\Presence;

use App\Domain\Presence\Service\CreatePresenceService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreatePresenceAction
{
    /**
     * @var CreatePresenceService
     */
    private CreatePresenceService $service;

    /**
     * @param CreatePresenceService $service
     */
    public function __construct(CreatePresenceService $service)
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
        $place = $request->getParsedBody()['place'];

        $result = $this->service->createPres($args['id'], $place);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}