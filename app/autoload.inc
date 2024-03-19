<?php

session_start();

// Include the config and CPanel files
require_once dirname(__FILE__) . '/bootstrap/configs.php';

// Set CSP header with nonce and image source directives
header("Content-Security-Policy: default-src 'self' data:; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
setcookie('source', DOMAIN_SOURCE, time() + 24 * 60 * 60, '/');  // Expires in 16 Days

use App\Bootstrap\Web;
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

        if (LOADINGPROCESS) : echo "<br> $className is exist";
        endif;

    else :
        $message = "Sorry, the ({$className}) requested module is not defined or does not exist. Please check the module name and try again";

        error_log("Class file not found: $className");

        if (LOADINGPROCESS) echo "Class file not found: $className";

        exit;
    endif;
});

// Implement request rate limiting logic
$isSpam = Security::isSpam();

// Check if the request is not spam or in DEBUGMODE
if (!$isSpam || DEBUGMODE) :
    // if (!$isSpam) :
    $router = new Web;

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
