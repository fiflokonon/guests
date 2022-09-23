<?php

namespace App\Domain\Core\Middleware;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;


class Error
{

    private Response $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param ResponseInterface $response
     * @param int $statusCode
     * @param string $message
     * @return ResponseInterface
     */
    public function setErrors(ResponseInterface $response, int $statusCode, string $message): ResponseInterface
    {
        $response->getBody()->write(json_encode(["success" => false, "statusCode" => $statusCode, 'message' => $message]));
        return $response->withStatus($statusCode)->withHeader('content-Type', 'application/json');
    }
}