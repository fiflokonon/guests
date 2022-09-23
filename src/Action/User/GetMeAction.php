<?php

namespace App\Action\User;

use App\Domain\Core\Middleware\Error;
use App\Domain\User\Service\GetMeService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function DI\string;

final class GetMeAction
{
    private GetMeService $service;
    private Error $error;
    public function __construct(GetMeService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    )
    {
        //Get JWT
        if (isset($_SERVER['HTTP_AUTHORIZATION']))
        {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            $arr = explode(" ",(string($authHeader)));
            if ($arr[0] = "Bearer")
            {
                $jwt = $arr[1];
                if ($jwt)
                {
                    //Invoke
                    $result = $this->service->returnMe($jwt);

                    //Build HTTP Response
                    $response->getBody()->write(json_encode($result));
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
                }else
                {
                    $response = new Response();
                    return $this->error->setErrors($response, 404, 'Token not found');
                }
            }
            else{
                $response = new Response();
                return $this->error->setErrors($response, 401, 'Unauthorized');
            }
        }
    }
}