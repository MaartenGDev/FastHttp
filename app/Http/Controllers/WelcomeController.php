<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    public function hello($name,$job){
        return new Response('Hello ' . $name . ' you have the following job '. $job);
    }
}