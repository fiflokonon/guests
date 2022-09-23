<?php

namespace App\Action\Event;

use App\Action\User\EditUserAction;
use App\Domain\Event\Service\EditEventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditEventAction
{
    /**
     * @var EditEventService
     */
    private EditEventService $service;

    /**
     * @param EditEventService $service
     */
    public function __construct(EditEventService $service)
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

        // TODO: Implement __invoke() method.
        $result = $this->service->editEvent($args['id'], $data);

        //Build HTTP Response
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}