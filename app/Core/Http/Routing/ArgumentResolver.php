<?php

namespace App\Core\Http\Routing;


use App\Repositories\PostRepository;
use Illuminate\Container\Container;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;

class ArgumentResolver extends Container
{
    private $request;
    private $parameters;
    private $controller;
    private $namespace = 'App\Http\Controllers\\';
    private $method;

    public function __construct($parameters,Request $request)
    {
        $this->request = $request;
        $this->parameters = $parameters[2];

        $controllerAndMethod = explode('@',$parameters[1]);

        $this->controller = $this->namespace . $controllerAndMethod[0];
        $this->method = $controllerAndMethod[1];
    }

    public function getController(){

       return $this->getControllerInstance($this->controller);
    }

    public function getMethod(){
        return $this->method;
    }

    public function getControllerInstance($controller){
        $reflection = new ReflectionClass($controller);

        $constructor = $reflection->getConstructor();

        $parameters = array_map(function($parameter){
            return $this->make($parameter->getClass()->getName());
        },$constructor->getParameters());

        return $reflection->newInstanceArgs($parameters);
    }

    public function getArguments(){
        $arguments = [];

        $reflection = new ReflectionClass($this->controller);
        $parameters = $reflection->getMethod($this->method)->getParameters();

       foreach($parameters as $parameter){
           $value = $this->parameters[$parameter->name];

           if(!is_null($parameter->getClass()) && $parameter->getClass()->getName() == Request::class){
                $value = $this->request;
           }

           $arguments[$parameter->name] = $value;
        }
        return $arguments;
    }
}