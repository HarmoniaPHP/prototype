<?php

use Harmonia\Framework\Controller\BaseController;
use Harmonia\Framework\Http\Kernel;
use Harmonia\Framework\Routing\Router;
use Harmonia\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\BooleanArgument;
use League\Container\Argument\Literal\IntegerArgument;
use League\Container\Argument\Literal\StringArgument;
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

$templateDir = BASE_PATH . '/views';
$configDir = BASE_PATH . '/storage/framework/config';
$compileDir = BASE_PATH . '/storage/framework/views';
$cacheDir = BASE_PATH . '/storage/framework/cache/data';

$compileCheck = (in_array(env('APP_ENV'), ['dev', 'test']
)) ? \Smarty\Smarty::COMPILECHECK_ON : \Smarty\Smarty::COMPILECHECK_OFF;

$container->addShared('smarty', \Smarty\Smarty::class)
    ->addMethodCall('setTemplateDir', [new StringArgument($templateDir)])
    ->addMethodCall('setConfigDir', [new StringArgument($configDir)])
    ->addMethodCall('setCompileDir', [new StringArgument($compileDir)])
    ->addMethodCall('setCacheDir', [new StringArgument($cacheDir)])
    ->addMethodCall('setCompileCheck', [new IntegerArgument($compileCheck)]);

$container->add(BaseController::class);
$container->inflector(BaseController::class)->invokeMethod('setContainer', [$container]);

return $container;
