<?php
if(!function_exists('contains')){

    function contains($haystack,$needle){
        return strpos($haystack,$needle) !== false;
    }
}

if(!function_exists('home')){

    function home(){
        return __DIR__ . '/../../../';
    }
}
if(!function_exists('path')){


    function path($key){
        $items = [
          'logs' => 'storage/logs/'
        ];

        return home() . $items[$key];
    }
}
if(!function_exists('explodeUrl')){

    function explodeUrl($url,$offset = 0){
        $urlComponents = explode('/',substr($url,$offset));

        return array_filter($urlComponents,function($component) {
            return $component != '';
        });
    }
}
if(!function_exists('getProjectFolder')){
    function getProjectFolder(){
        return substr(str_replace('/index.php','',$_SERVER['DOCUMENT_URI']),1);
    }
}