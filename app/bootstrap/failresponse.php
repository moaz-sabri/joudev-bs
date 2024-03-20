<?php

namespace App\Bootstrap;

use App\Modules\Public\PublicUrls;

class FailResponse extends Response
{
    public function __construct($statusCode = 404)
    {

        $type = 'bad-request';
        $error_title = 'Bad Request';

        switch ($statusCode):
            case 400:
                $type = 'bad-request';
                $error_title = 'Bad Request';
                break;

            case 401:
                $type = 'unauthorized';
                $error_title = 'Unauthorized';
                break;

            case 403:
                $type = 'forbidden';
                $error_title = 'Forbidden';
                break;

            case 500:
                $type = 'internal-server-error';
                $error_title = 'Internal Server Error';
                break;

            case 503:
                $type = 'service-unavailable';
                $error_title = 'Service Unavailable';
                break;
        endswitch;
        // Start output buffering
        ob_start();

        include_once PublicUrls::$resource . "errors/{$type}.blade.php";

        // Get the content of the buffer and clean it
        $content = ob_get_clean();

        parent::__construct($content, $statusCode);
    }
}
