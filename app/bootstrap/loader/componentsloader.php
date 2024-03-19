<?php

namespace App\Bootstrap\Loader;

trait ComponentsLoader
{
    public function autoloadComponents($obj)
    {
        define("COMPONENTS", WEBROOT . '/templates/components/');
        define("USETHEME", WEBROOT . "/templates/themes/{$obj->theme}/");
    }
}
