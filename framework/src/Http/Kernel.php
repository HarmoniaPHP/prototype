<?php

namespace Harmonia\Framework\Http;


use Harmonia\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{

    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHandler, $vars);
        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), $exception->getStatusCode());
        } catch (\Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array(env('APP_ENV'), ['dev', 'test'])) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }

        return new Response('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
