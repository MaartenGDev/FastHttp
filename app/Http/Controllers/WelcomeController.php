<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    public function hello(){
        return new Response('Hello world!');
    }
}