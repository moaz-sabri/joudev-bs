<?php

session_start();

// Include the config and CPanel files
require_once dirname(__FILE__) . '/bootstrap/configs.php';

// Set CSP header with nonce and image source directives
header("Content-Security-Policy: default-src 'self' data:; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
setcookie('source', DOMAIN_SOURCE, time() + 24 * 60 * 60, '/');  // Expires in 16 Days

use App\Bootstrap\Request;
use App\Bootstrap\Router;
use App\Bootstrap\Routes;
use App\Bootstrap\Security;

/**
 * Autoload Classes from Namespace
 *
 * This function is used with spl_autoload_register to automatically load classes
 * based on the namespace and directory structure.
 *
 * @param string $className The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register(function ($className): void {
    // Convert namespace separators to directory separators
    $className = strtolower(
        str_replace(
            ['App', '\\'],
            ['', '/'],
            $className
        ) . '.php'
    );

    // Check if the class file exists
    if (file_exists(WEBROOT . $className)) :
        // Build the full path to the class file
        require_once WEBROOT . $className;

        $message =  "<br> $className is exist ";
    else :
        $message = "Class file not found: $className";
    endif;

    if (LOADINGPROCESS) echo $message;
});

// Implement request rate limiting logic
$isSpam = Security::isSpam();

// Check if the request is not spam or in DEBUGMODE
if (!$isSpam || DEBUGMODE) :
    $router = new Router();

    $routes = new Routes();
    $routes->loadModules('Extends', $router);
    $routes->loadModules('Modules', $router);

    // Simulate a request
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestPath = $_SERVER['REQUEST_URI'];
    $request =  new Request($requestMethod, $requestPath);
    $response = $router->dispatch($request);
    $response->send();

    // var_dump($request->path);
    // var_dump($request->method);
    // var_dump($request->data);
    // var_dump($response->getResponse());
    // var_dump($response->getStatusCode());

    if (LOADINGPROCESS) : echo "Ready to preview!";
    endif;

else :
    // Log or handle the spam attempt (e.g., block the IP)
    $error_code = 500;
    $error_title = 'Blocked IP';
    http_response_code($error_code);
    require_once __DIR__ . '/modules/cpanel/views/errors/bad-request.blade.php';;

    // Check and unblock IPs after 30 minutes
    Security::unblockOldAttempts();
endif;

if (LOADINGPROCESS) echo "loaded Autoload";

session_write_close();
die;
