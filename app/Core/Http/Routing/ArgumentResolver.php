<?php


namespace App\Core\Http\Routing;


use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;

class ArgumentResolver
{
    private $request;
    private $parameters;
    private $controller;
    private $namespace = 'App\Http\Controllers\\';
    public function __construct($parameters,Request $request)
    {
        $this->request = $request;
        $this->parameters = $parameters[2];
        $this->controller = $this->namespace . $parameters[1];
    }

    public function getController(){
     return str_replace('@','::',$this->controller);
    }

    public function getArguments(){
        list($controller,$method) = explode('@',$this->controller);

        $arguments = [];

        $reflection = new ReflectionClass($controller);
        $parameters = $reflection->getMethod($method)->getParameters();

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