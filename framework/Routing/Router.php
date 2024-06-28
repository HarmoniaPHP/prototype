<?php

namespace Harmonia\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Harmonia\Framework\Http\HttpException;
use Harmonia\Framework\Http\HttpRequestMethodException;
use Symfony\Component\HttpFoundation\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
    {
        $routeInfo = $this->extractRouteInfo($request);

        [$handler, $vars] = $routeInfo;

        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $handler = [new $controller(), $method];
        }

        return [$handler, $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new HttpException('Not Found', 404);
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                throw new HttpRequestMethodException("Method Not Allowed. Allowed methods: $allowedMethods");
        }

        return [$routeInfo[1], $routeInfo[2]];
    }
}
