<?php

namespace App\Controllers;

use Harmonia\Framework\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
    public function index(): Response
    {
        return $this->view('home', [
            'title' => 'Harmonia',
            'textOne' => '<strong>Harmonia</strong> is a <strong>PHP framework</strong> for building web applications.',
            'textTwo|html' => '<strong>Harmonia</strong> is a <strong>PHP framework</strong> for building web applications.',
        ]);
    }
}
