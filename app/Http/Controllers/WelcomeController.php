<?php


namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use app\Repositories\PostRepository;
use App\User;

class WelcomeController
{
    /**
     * @var PostRepository
     */
    private $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function show(User $user){
        return new Response('user here');
    }
    public function hello($name,$job){
        $user = new User();
        $user->name = $name;

        $user->save();

        return new Response('Hello ' . $name . ' you have the following job '. $job);


    }
}