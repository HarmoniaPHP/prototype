<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Symfony\Component\HttpFoundation\Response;

return [
    ['GET', '/', [HomeController::class, 'index']],
    [
        'GET',
        '/posts/create',
        function () {
            return new Response('Create Post', 200);
        }
    ],
    ['GET', '/posts/{id}', [PostController::class, 'show']],
];
