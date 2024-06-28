<?php

namespace Harmonia\Framework\Routing;

use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    public function dispatch(Request $request): array;
}
