<?php

use Harmonia\Framework\Http\Kernel;
use Harmonia\Framework\Routing\Router;
use Harmonia\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer(true));

// parameters for application configuration
$routes = include BASE_PATH . '/routes/web.php';

// services
$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('setRoutes', [
    new ArrayArgument($routes),
]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

return $container;
