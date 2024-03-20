<?php

namespace App\Extends\Translation\Loader;

use App\Utilities\Utilitie;

class LanguageLoader extends Utilitie
{

    public static $defaultLanguage = 'en'; // Default language
    public $languageData;
    public static $availableLanguages = []; // Default language
    public static $existLanguages = ['en', 'ar', 'de']; // Default language

    // Replace this with the path to your directory
    public static $directory = STORAGE . "languages";


    function __construct()
    {
        // Use glob to get a list of XML files
        self::$availableLanguages =  glob(self::$directory . "/*/index.xml");
    }

    function load($lang = false): void
    {
        // If a specific language is provided, use it; otherwise, use the default language
        self::$defaultLanguage = !$lang ? $_SESSION['language'] : $lang;
        $this->set("/index.xml");
    }

    function moreLabels($language)
    {
        if (is_array($language)) :
            foreach ($language as $key => $lan) :
                $this->set($lan . ".xml");
            endforeach;
        else :
            $this->set($language . ".xml");
        endif;
    }

    private function set($file)
    {
        $languageFile = self::$directory . DS . self::$defaultLanguage . DS . $file;
        if (file_exists($languageFile)) :
            $xml = simplexml_load_file($languageFile);

            foreach ($xml->phrase as $phrase) :
                $this->languageData[(string) $phrase['name']] = (string) $phrase;
            endforeach;
        endif;
    }

    function get(string|null $key = 'fail-label', string $default = null): string
    {
        $label = 'label:' . $key;

        if (isset($this->languageData[$key]) && !empty($this->languageData[$key])) :
            $label = $this->languageData[$key];
        elseif (!is_null($default) && !empty($default)) :
            $label = $default;
        endif;

        return $label;
    }
}
