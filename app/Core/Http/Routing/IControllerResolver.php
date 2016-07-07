<?php


namespace App\Core\Http\Routing;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

interface IControllerResolver
{
    public function getController(RouteCollection $collection,Request $request);
    public function requestMatchRoute(Request $request,Route $route);

}