<?php

namespace App\Modules\Public;

use App\Bootstrap\Routes;
use App\Modules\Public\Api\PublicApi;
use App\Modules\Public\Controller\PublicController;

class PublicUrls extends Routes
{
    static $resource = __DIR__ . '/views/';

    function __construct($router)
    {
        $router->get($this->getPath('home'), new PublicController, 'index');
        $router->get($this->getPath('impression'), new PublicController, 'impression');
        $router->get($this->getPath('policy'), new PublicController, 'policy');
    }
}
