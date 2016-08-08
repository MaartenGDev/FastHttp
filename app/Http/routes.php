<?php
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('GET', '/users/{name}/{job}', 'WelcomeController@hello');

});

return $dispatcher;
