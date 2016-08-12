<?php
use App\Http\Kernel;
use Symfony\Component\HttpFoundation\Request;


/*
|--------------------------------------------------|
|               Load the autoloader                |
|--------------------------------------------------|
|
|   Composer provides an easy autoloader
|   that loads the right files for the
|   requested class.
|
*/
require_once __DIR__.'/../vendor/autoload.php';

/*
|---------------------------------------------
| Run The Application
|---------------------------------------------
|
| Run the application using the Kernel class.
|
*/

$kernel = new Kernel();

$response = $kernel->handle(
    $request = Request::createFromGlobals()
);


$response->send();



