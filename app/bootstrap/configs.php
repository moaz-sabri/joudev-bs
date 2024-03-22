<?php

namespace App\Bootstrap;

// Size of memory limit
ini_set('memory_limit', '30M');

// Mode;
// The mode of production or local environment
define('PRODUCTION', filter_var(strncmp(__FILE__, '/home', 5) === 0, FILTER_VALIDATE_BOOLEAN));  // Set to true for production, false for local environment

// The debug mode to preview errors and bug messages
define('DEBUGMODE', true); // Set to true for debugging, false for regular mode
define('LOADINGPROCESS', false); // Set to true for debug mode, false for production

// Directory separator
define('DS', DIRECTORY_SEPARATOR);
// Webroot path
define('WEBROOT', realpath(dirname(__FILE__)) . DS . '..');
// Storage path
define('STORAGE', realpath(dirname(__DIR__)) . DS . '..' . DS . 'storage' . DS);
// Root path
define('ROOT', WEBROOT . DS . '..' . DS . 'public' . DS);

// glouble Setting

// Secret Key
define('SECRET_KEY', 'SECRET_KEY'); // Replace 'your_secret_key_here' with your actual secret key
// license
define('LICENSE', 'LICENSE'); // Replace 'your_license_variable_name' with your actual license variable name
// Generate a nonce value for this page load
define('NONCE', base64_encode(random_int(PHP_INT_MIN, PHP_INT_MAX)));

// Date Format
define('DATE_FORMAT', "j, M | y"); // Display date format, e.g., 'M, j | Y'
// View Date
define('DATE_VIEW', "G:i - j, M | y"); // Date format for views, e.g., 'H:i - M, d | Y'
// Time Threshold
define('TIMETHRESHOLD', 60); // Time threshold in seconds, e.g., 24 hours
// Request Threshold
define('REQUESTTHRESHOLD', 25); // Maximum allowed requests within a threshold
// Block Time Limit
define('BLOCKTIMELIMIT', 1800); // Block time limit in seconds, e.g., 10 minutes

// Meta
// Author Name
define('AUTHOR_NAME', 'Moaz Sabri');
// Project Name
define('PROJECT_NAME', 'PROJECT_NAME'); // Replace 'Your Project' with the actual project name
// Title Page
define('TITLE_PAGE', 'TITLE_PAGE'); // Replace 'Your Page Title' with the desired page title
// Description
define('DESCRIPTION', 'DESCRIPTION'); // Replace with a brief project description
// Keywords
define('KEYWORDS', 'KEYWORDS'); // Replace with relevant keywords
// Logo
define('LOGO', '/public/assets/placeholder.webp'); // Replace with the actual path to your logo image
// Thumbnail
define('THUMBNAIL', '/public/assets/placeholder.webp'); // Replace with the actual path to your thumbnail image
// Contact Email
define('CONTACT_MAIL', 'CONTACT_MAIL'); // Replace 'info@example.com' with the actual contact email

// Check if the application is in debug mode
if (DEBUGMODE) {
    // If in debug mode, display errors to aid development

    // Set PHP to display all errors
    ini_set('display_errors', 1);

    // Set PHP to display startup errors
    ini_set('display_startup_errors', 1);

    // Report all errors
    error_reporting(E_ALL);
} else {
    // If not in debug mode, hide errors for a cleaner production environment

    // Disable displaying errors
    ini_set('display_errors', 0);

    // Disable displaying startup errors
    ini_set('display_startup_errors', 0);

    // Disable error reporting
    error_reporting(0);
}

// Database configuration
if (PRODUCTION) :
    // Source Path of the Project
    define('DOMAIN_SOURCE', 'https://webbase.joudev.com'); // Replace '/path/to/your/project' with the actual source path of your project
else :
    // Source Path of the Project
    define('DOMAIN_SOURCE', "http://localhost:5000"); // Replace '/path/to/your/project' with the actual source path of your project
endif;

// Store the current URL in the session
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

function debug($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

if (LOADINGPROCESS) debug("Debug Mode is enabled!");
