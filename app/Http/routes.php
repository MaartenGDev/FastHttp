<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$welcome = new Route('/', array(
    '_controller' => 'WelcomeController@hello'
));

$welcome->setMethods(['GET']);

$routes->add('welcome',$welcome);

return $routes;