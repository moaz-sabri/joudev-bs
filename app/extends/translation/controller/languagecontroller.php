<?php

namespace App\Extends\Translation\Controller;

use App\Extends\Translation\Loader\LanguageLoader;
use App\Utilities\Utilitie;

class LanguageController extends Utilitie
{
    public function switchLanguage($request)
    {
        if (in_array($request->routeParams->key, LanguageLoader::$existLanguages)) :
            $_SESSION['language'] = $request->routeParams->key;
        endif;

        // Check if location is provided in the query parameters
        if (isset($request->queryParams->location)) {
            $location = $request->queryParams->location;
        } else {
            // If not provided, redirect to home page or any default location
            $location = '/';
        }

        // Redirect to the specified location
        header("Location: $location");
        exit; // Ensure that no further output is sent after the redirect
    }
}
