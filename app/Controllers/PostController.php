<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class PostController
{
    public function show(int $id): Response
    {
        return new Response('Post ID: ' . $id);
    }
}
