<?php

namespace App\Action\Event;

use App\Domain\Event\Service\CreateEventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateEventAction
{
    /**
     * @var CreateEventService
     */
    private CreateEventService $service;

    /**
     * @param CreateEventService $service
     */
    public function __construct(CreateEventService $service)
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
        //Get Data
        $data = $request->getParsedBody();

        //TODO: Invoke()
        $result = $this->service->createEvent($args['id'], $data);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}