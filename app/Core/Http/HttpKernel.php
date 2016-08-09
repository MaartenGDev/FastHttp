<?php


namespace App\Core\Http;

use App\Core\Http\Routing\ArgumentResolver;
use FastRoute\Dispatcher as Router;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class HttpKernel
{
    public function sendRequestThroughRouter(Request $request)
    {

        $controllerAndParameters = $this->matchRouteAndGetParameters($request);

        $arguments = new ArgumentResolver($controllerAndParameters, $request);

        return call_user_func_array(
            $arguments->getController(),
            $arguments->getArguments()
        );
    }

    private function matchRouteAndGetParameters(Request $request)
    {
        $routes = require_once home() . 'app/Http/routes.php';


        $routeStatus = $routes->dispatch(
            $request->server->get('REQUEST_METHOD'),
            $request->server->get('REQUEST_URI')

        );
        $status = $routeStatus[0];

        if ($status === Router::NOT_FOUND) {
            throw new NotFoundHttpException();
        }

        if ($status === Router::METHOD_NOT_ALLOWED) {
            throw new MethodNotAllowedException($routes->variableRouteData);
        }


        return $routeStatus;
    }

    private function registerEloquent()
    {

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'MoveThisToEnvFile',
            'username' => 'root',
            'password' => 'secure',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

    }

    public function handle(Request $request)
    {
        $this->registerEloquent();
        return $this->sendRequestThroughRouter($request);
    }
}