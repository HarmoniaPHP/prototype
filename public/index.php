<?php

declare(strict_types=1);

use Harmonia\Framework\Http\Kernel;
use Symfony\Component\HttpFoundation\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();
