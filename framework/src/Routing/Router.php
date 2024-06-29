<?php

namespace Harmonia\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Harmonia\Framework\Http\HttpException;
use Harmonia\Framework\Http\HttpRequestMethodException;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    private array $routes;

    public function dispatch(Request $request, ContainerInterface $container): array
    {
        $routeInfo = $this->extractRouteInfo($request);

        [$handler, $vars] = $routeInfo;

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);
            $handler = [$controller, $method];
        }

        return [$handler, $vars];
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->routes as $route) {
                $collector->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $exception = new HttpException('Not Found', 404);
                $exception->setStatusCode(Response::HTTP_NOT_FOUND);
                throw $exception;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                $exception = new HttpRequestMethodException("Method Not Allowed. Allowed methods: $allowedMethods");
                $exception->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
                throw $exception;
        }

        return [$routeInfo[1], $routeInfo[2]];
    }
}
