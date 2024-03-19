<?php

namespace App\Modules\Public;

use App\Bootstrap\Web;
use App\Modules\Public\Controller\PublicController;

class PublicUrls extends Web
{
    static $resource = __DIR__ . '/views/';

    function __construct($router)
    {
        $router->get($this->getPath('home'), new PublicController, 'index');

        $router->get([
            '/404',
            '/405',
            '/500',
            '/503',
        ], new PublicController, 'errors');
    }
}
