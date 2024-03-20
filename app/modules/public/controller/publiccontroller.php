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
    public function impression()
    {
        return (object) [
            'view' => PublicUrls::$resource . 'impression',
            'meta' => ['title' => 'Impression | ' . PROJECT_NAME],
            'statusCode' => 200
        ];
    }
    public function policy()
    {
        return (object) [
            'view' => PublicUrls::$resource . 'policy',
            'meta' => ['title' => 'Policy | ' . PROJECT_NAME],
            'statusCode' => 200
        ];
    }
}
