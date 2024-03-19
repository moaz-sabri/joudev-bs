<?php

namespace App\Bootstrap;

class Response
{
    private $content;
    private $statusCode;

    public function __construct($content, $statusCode = 200)
    {

        $this->content = $content;
        $this->statusCode = $statusCode;

        // Set HTTP response code
        http_response_code($statusCode);

        // Perform the redirection to the specified URL
        if ($statusCode === 301) :
            http_response_code($statusCode);
            header("Location: $content");
            die;

        elseif (!in_array($statusCode, [200, 204, 400])) :
            $this->errorPage($statusCode);
        endif;

        if (LOADINGPROCESS) debug("loaded Response (code: {$statusCode})");
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function send()
    {
        echo $this->content;
    }

    private static function errorPage($statusCode)
    {
        $error_code = $statusCode;
        $error_title = 'Not Found';
        switch ($statusCode) {
            case 401:
                $file = '/../modules/cpanel/views/errors/unauthorized.blade.php';
                $error_title = 'Unauthorized';
                break;

            case 403:
                $file = '/../modules/cpanel/views/errors/forbidden.blade.php';
                $error_title = 'Forbidden';
                break;

            case 500:
                $file = '/../modules/cpanel/views/errors/internal-server-error.blade.php';
                $error_title = 'Internal Server Error';
                break;

            case 503:
                $file = '/../modules/cpanel/views/errors/service-unavailable.blade.php';
                $error_title = 'Service Unavailable';
                break;

            default:
                $file = '/../modules/cpanel/views/errors/not-found.blade.php';
                break;
        }

        $viewFile = __DIR__ . $file;

        if (file_exists($viewFile)) {


            include_once $viewFile;

            if (LOADINGPROCESS) debug("loaded file {$viewFile}");
        } else {
            return "View '$viewFile' not found";
        }
    }
}
