<?php


namespace App\Core\Http;

use App\Core\Http\Routing\ArgumentResolver;
use App\Core\Http\Routing\ControllerResolver;
use FastRoute\Dispatcher;
use HttpRequestMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class HttpKernel
{
    public function sendRequestThroughRouter(Request $request){

        $controllerAndParameters = $this->matchRouteAndGetParameters($request);

        $arguments = new ArgumentResolver($controllerAndParameters,$request);

        return call_user_func_array(
            $arguments->getController(),
            $arguments->getArguments()
        );
    }

    public function matchRouteAndGetParameters(Request $request){
        $routes = require_once home().'app/Http/routes.php';


        $routeStatus = $routes->dispatch(
            $request->server->get('REQUEST_METHOD'),
            $request->server->get('REQUEST_URI')

        );

        if($routeStatus[0] === Dispatcher::NOT_FOUND){
            throw new NotFoundHttpException();
        }

        if($routeStatus[0] === Dispatcher::METHOD_NOT_ALLOWED){
            throw new MethodNotAllowedException($routes->variableRouteData);
        }


        return $routeStatus;
    }

    public function handle(Request $request){
       return $this->sendRequestThroughRouter($request);
    }
}