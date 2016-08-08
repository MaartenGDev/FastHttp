<?php

namespace App\Core\Http\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouteCollection;

class ControllerResolver implements IControllerResolver
{
    private $namespace = 'App\\Http\\Controllers\\';
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getController(RouteCollection $collection, Request $request){
        $controller = false;

        if(!$controller){
            throw new NotFoundHttpException('Page Not Found',null,404);
        }
        // Set correct namespace
        $controller[0] = $this->namespace . $controller[0];

        return [$controller,$this->request];
    }
}