<?php

namespace App\Modules\Public\Controller;

use App\Modules\Public\PublicUrls;

class PublicController
{
    public function index()
    {
        return (object) [
            'view' => PublicUrls::$resource . 'index',
            'meta' => ['title' => 'Home | ' . PROJECT_NAME],
            'statusCode' => 200
        ];
    }
}
