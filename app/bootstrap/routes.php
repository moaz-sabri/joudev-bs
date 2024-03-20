<?php

namespace App\Bootstrap;

class Routes
{

    private static $lastForwardSlash = [
        'get_manger_dashboard'
    ];

    // Routers
    private static $paths =  [
        'home' => '',
        'impression' => 'impression',
        'policy' => 'policy',
    ];

    public static function getPath($name)
    {
        // Remove the last forward slash
        $path = isset(self::$paths[$name]) ? '/' . self::$paths[$name] : '/';

        if (in_array($name, self::$lastForwardSlash)) $path = rtrim($path, '/');

        return $path;
    }

    public function loadModules($scope, $router)
    {
        // Define the directory where module files are located
        $directory = __DIR__ . "/../{$scope}/"; // Replace this with the path to your directory

        // Use glob to get an array of Modules files in the directory
        $package = glob($directory . "*");

        // Use array_map to extract file names from the array
        $availablePackage = array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, $package);

        // Iterate through each availablePackage module
        foreach ($availablePackage as $key => $module) :
            $className = ucwords($module);

            // Construct the full class name for the module's Setting class
            $className = "App\\{$scope}\\{$className}\\{$className}Urls";

            if (class_exists($className)) :
                new $className($router);
            endif;

        endforeach;
    }
}
