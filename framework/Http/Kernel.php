<?php

namespace Harmonia\Framework\Http;

use Harmonia\Framework\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{

    public function __construct(private RouterInterface $router)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 400);
        }

        return $response;
    }
}
