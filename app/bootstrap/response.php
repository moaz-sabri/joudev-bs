<?php

namespace App\Bootstrap;

class Response
{
    private $content;
    private static $response;
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
        endif;

        if (LOADINGPROCESS) debug("loaded Response (code: {$statusCode})");
    }

    public static function setResponse($response)
    {
        self::$response = $response;
    }
    public function getResponse()
    {
        return self::$response;
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
}
