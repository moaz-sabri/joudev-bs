<?php

namespace App\Bootstrap;

class JsonResponse extends Response
{
    public function __construct($data, $statusCode = 200)
    {

        // Set the response content type to JSON and exit with the JSON data
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Expires: 0');
        header('Pragma: no-cache');

        $content = json_encode($data);
        parent::__construct($content, $statusCode);
    }
}
