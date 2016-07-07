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

        $requestUri = $this->cleanRequestUri(
            $request->server->get('REQUEST_URI')
        );

        $requestParts = explodeUrl($requestUri);



        $routeParts = array_map(function($route,$uri){
            if(contains($route,'{')) {
                $placeholder = str_replace(['{','}'],'',$route);

                $this->request->request->set($placeholder,$uri);

                return $uri;
            }
            return $route;
        },$routeParts,$requestParts);

        if(count($requestParts) == 0){
            $requestUri = '/';
        }
        if(count($routeParts) > 0){
            $routeUri = implode('/',$routeParts);
        }else{
            $routeUri = '/';
        }
        $requestMethodIsAllowedMethod = in_array($request->getMethod(),$route->getMethods());


        return $requestMethodIsAllowedMethod &&  $routeUri == $requestUri;
    }
    public function cleanRequestUri($requestParts){

        // If someone requested from the root of a folder.
        $requestUri = implode('/',$requestParts);


        // Remove Folder preview if the project is placed inside a folder.
        $requestUri = str_replace(getProjectFolder(),'',$requestUri);

        return $requestUri !== '' ? $requestUri : '/';
    }

}