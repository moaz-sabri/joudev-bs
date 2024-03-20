<?php

namespace App\Extends\Translation;

use App\Bootstrap\Routes;
use App\Extends\Translation\Controller\LanguageController;

class TranslationUrls extends Routes
{

    // this inported in ClassName
    static $resource = __DIR__ . '/views/';

    function __construct($router)
    {
        $router->get($this->getPath('get_switch_language') . '{key}', new LanguageController, 'switchLanguage');
    }
}
