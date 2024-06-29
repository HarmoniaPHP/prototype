<?php

namespace Harmonia\Framework\Routing;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;

    public function setRoutes(array $routes): void;
}
