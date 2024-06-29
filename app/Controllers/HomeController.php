<?php

namespace App\Controllers;

use App\Widget;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __construct(private Widget $widget)
    {
    }

    public function index(): Response
    {
        return new Response('Hello World from ' . $this->widget->name);
    }
}
