<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Symfony\Component\HttpFoundation\Response;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/posts', [PostController::class, 'index']],
    ['GET', '/posts/create', [PostController::class, 'create']],
    ['POST', '/posts', [PostController::class, 'store']],
    ['GET', '/posts/{id}', [PostController::class, 'show']],
];
