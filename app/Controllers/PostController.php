<?php

namespace App\Controllers;

use Harmonia\Framework\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends BaseController
{
    private array $posts = [
        ['title' => 'Post 1', 'content' => 'lorem ipsum dolor sit amet'],
        ['title' => 'Post 2', 'content' => 'lorem ipsum dolor sit amet'],
        ['title' => 'Post 3', 'content' => 'lorem ipsum dolor sit amet'],
    ];

    public function index(): Response
    {
        return $this->view('posts/list', [
            'posts' => $this->posts,
        ]);
    }

    public function show(int $id): Response
    {
        $post = $this->posts[$id - 1] ?? null;

        if ($post === null) {
            exit('Post not found');
        }

        return $this->view('posts/show', ['post' => $post]);
    }

    public function create(): Response
    {
        return $this->view('posts/create');
    }

    public function store()
    {
    }


}
