<?php

namespace App\Modules\Public\Controller;

use App\Modules\Public\PublicUrls;

class PublicController
{
    public function index()
    {
        return (object) [
            'view' => PublicUrls::$resource . 'index',
            'meta' => ['title' => 'Home | ' . PROJECT_NAME]
        ];
    }

    public function errors($request)
    {
        $statusCode =  trim($request->path, '/');

        switch ($statusCode):
            case 400:
                $file = 'errors/bad-request';
                $error_title = 'Bad Request';
                break;

            case 401:
                $file = 'errors/unauthorized';
                $error_title = 'Unauthorized';
                break;

            case 403:
                $file = 'errors/forbidden';
                $error_title = 'Forbidden';
                break;

            case 500:
                $file = 'errors/internal-server-error';
                $error_title = 'Internal Server Error';
                break;

            case 503:
                $file = 'errors/service-unavailable';
                $error_title = 'Service Unavailable';
                break;

            default:
                $file = 'errors/not-found';
                $error_title = 'Not Found';
                break;
        endswitch;

        return (object) [
            'view' => PublicUrls::$resource . $file,
            'data' => [],
            'theme' => false,
            'meta' => ['title' => $error_title]
        ];
    }
}
