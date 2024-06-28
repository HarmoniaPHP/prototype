<?php

declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Harmonia\Framework\Http\Kernel;
use Harmonia\Framework\Routing\Router;
use Symfony\Component\HttpFoundation\Request;

define('BASE_PATH', dirname(__DIR__));

$request = Request::createFromGlobals();

$router = new Router();

$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();
