<?php

namespace Harmonia\Framework\Controller;

use Psr\Container\ContainerInterface;
use Smarty\Smarty;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{

    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function view(string $view, array $params = [], Response $response = null): Response
    {
        if (!str_ends_with($view, '.tpl')) {
            $view .= '.tpl';
        }

        foreach ($params as $key => $value) {
            if (str_ends_with($key, '|html')) {
                $param = substr($key, 0, -5);
                $params[$param] = $value;
                unset($params[$key]);
                continue;
            }

            $params[$key] = htmlspecialchars($value);
        }

        $smarty = $this->container->get('smarty');

        $view = $smarty->fetch($view, $params);

        $response ??= new Response();
        $response->setContent($view);

        return $response;
    }
}
