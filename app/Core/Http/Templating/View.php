<?php


namespace App\Core\Http\Templating;


use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{
    protected $template;
    protected $parameters;


    public function __construct($template,$parameters = array()){
        $this->template = $this->getTemplate($template);
        $this->parameters = $parameters;
    }

    private function getTemplate($template){
        $file = $template . '.twig';
        $path = path('storage','views');

        if(!file_exists($path . $file)){
            throw new FileNotFoundException($path . $file);
        }

        return $file;
    }

    public function send(){
        $loader = new Twig_Loader_Filesystem(path('storage','views'));
        $twig = new Twig_Environment($loader, array(
            'cache' => path('storage','views_cache'),
        ));

        echo $twig->render($this->template, $this->parameters);
    }
}