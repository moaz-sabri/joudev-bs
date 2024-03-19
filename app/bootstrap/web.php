<?php

namespace App\Bootstrap;

class Web
{
    private static $lastForwardSlash = [
        'get_manger_dashboard'
    ];

    // Routers
    private static $paths =  [
        'home' => '',
    ];

    function __construct()
    {
        $router = new Router;

        $this->loadExtends($router);
        $this->loadModules($router);

        // Simulate a request
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = $_SERVER['REQUEST_URI'];
        $request =  new Request($requestMethod, $requestPath);
        $response = $router->dispatch($request);
        $response->send();

        if (LOADINGPROCESS) debug("Ready to preview!");
    }

    private function loadExtends($router)
    {
        // Define the directory where module files are located
        $directory = __DIR__ . "/../extends/"; // Replace this with the path to your directory

        // Use glob to get an array of extends files in the directory
        $extends = glob($directory . "*");

        // Use array_map to extract file names from the array
        $available = array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, $extends);

        // Iterate through each available module
        foreach ($available as $key => $module) :
            $className = ucwords($module);

            // Construct the full class name for the module's Setting class
            $className = "App\\Extends\\{$className}\\{$className}Urls";

            if (class_exists($className)) :
                new $className($router);
            endif;

        endforeach;
    }

    private function loadModules($router)
    {
        // Define the directory where module files are located
        $directory = __DIR__ . "/../modules/"; // Replace this with the path to your directory

        // Use glob to get an array of Modules files in the directory
        $modules = glob($directory . "*");

        // Use array_map to extract file names from the array
        $available = array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, $modules);

        // Iterate through each available module
        foreach ($available as $key => $module) :
            $className = ucwords($module);

            // Construct the full class name for the module's Setting class
            $className = "App\\Modules\\{$className}\\{$className}Urls";

            if (class_exists($className)) :
                new $className($router);
            endif;

        endforeach;
    }

    public static function getPath($name)
    {
        // Remove the last forward slash
        $path = isset(self::$paths[$name]) ? '/' . self::$paths[$name] : '/';

        if (in_array($name, self::$lastForwardSlash)) $path = rtrim($path, '/');

        return $path;
    }
}
