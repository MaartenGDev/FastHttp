<?php
use App\Core\Application;
use App\Http\Kernel;
use app\Repositories\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\JsonResponseHandler;

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

$app = require_once '../bootstrap/app.php';

$app->bind('App\Repositories\PostRepository', function(){
    return new PostRepository();
});

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



