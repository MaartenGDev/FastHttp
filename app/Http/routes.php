<?php
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('GET', '/flight/new/{name}/{description}', 'WelcomeController@flight');
    $r->addRoute('GET', '/flight/{name}', 'WelcomeController@show');

});

return $dispatcher;
