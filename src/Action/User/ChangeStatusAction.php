<?php

namespace App\Action\User;

use App\Domain\User\Service\ChangeStatusService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChangeStatusAction
{
    /**
     * @var ChangeStatusService
     */
    private ChangeStatusService $statusService;

    /**
     * @param ChangeStatusService $statusService
     */
    public function __construct(ChangeStatusService $statusService)
    {
        $this->statusService = $statusService;
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
        //TODO: invoke()
        $result = $this->statusService->changeStatus($args['id']);
        //Build a HttpResponse
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}