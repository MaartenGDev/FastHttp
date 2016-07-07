<?php

namespace App\Core\Http\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Route;
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

        foreach($collection->all() as $key => $route) {
            if ($this->requestMatchRoute($request, $route)) {
                $controller = explode('@',$route->getDefault('_controller'));
                break;
            }
        }

        if(!$controller){
            throw new NotFoundHttpException('Page Not Found',null,404);
        }
        // Set correct namespace
        $controller[0] = $this->namespace . $controller[0];

        return [$controller,$this->request];
    }


    public function requestMatchRoute(Request $request,Route $route){

        $routeParts = explodeUrl($route->getPath());
        $requestParts = explodeUrl($request->server->get('REQUEST_URI'));

        $routeParts = array_map(function($route,$uri){
            if(contains($route,'{')) {
                $placeholder = str_replace(['{','}'],'',$route);

                $this->request->request->set($placeholder,$uri);

                return $uri;
            }
            return $route;
        },$routeParts,$requestParts);

        $requestMethodIsAllowedMethod = in_array($request->getMethod(),$route->getMethods());

        $routeUri = implode('/',$routeParts);
        $requestUri = implode('/',$requestParts);

        return  $requestMethodIsAllowedMethod &&  $routeUri == $requestUri;
    }

}