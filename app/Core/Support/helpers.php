<?php
use App\Core\Http\Templating\View;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

if (!function_exists('contains')) {

    function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('home')) {

    function home()
    {
        return __DIR__ . '/../../../';
    }
}
if (!function_exists('path')) {

    function path($type, $key)
    {
        $items = [
            'storage' => [
                'prefix' => '',
                'data' => [
                    'logs' => 'storage/logs/',
                    'views' => 'resources/views/',
                    'views_cache' => 'storage/views/'
                ]

            ],
            'config' => [
                'prefix' => '',
                'data' => [
                    'database' => 'config/database.php'
                ]
            ]
        ];

        return home() . $items[$type]['prefix'] . $items[$type]['data'][$key];
    }
}

if (!function_exists('getConfig')) {

    function getConfig($key)
    {
        $config = path('config', $key);
        if (!file_exists($config)){
            throw new FileNotFoundException($config);
        }

        return require_once $config;
    }
}

if (!function_exists('env')) {
    function env($key, $default)
    {
        $env = getenv($key);

        if (!$env) {
            return $default;
        }

        return $env;
    }
}

if (!function_exists('view')) {
    function view($template,$parameters){
        return new View($template, $parameters);
    }
}