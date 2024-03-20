<?php

namespace App\Bootstrap;

use App\Extends\Translation\Loader\LanguageLoader;

class Request
{
    public $path;
    public $method;
    public $data;
    public $user;
    public $routeParams;
    public $queryParams;

    public function __construct($method, $path)
    {
        $this->method = $method;
        $this->path = $this->getTranslate($path);
        $this->data = $this->getData($path);
        $this->parsePath();
        $this->parseQueryParams();

        if (LOADINGPROCESS) debug("loaded Request");
    }

    private function getData()
    {
        $inputs = [];
        $request = array_merge($_POST, $_GET);
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
            parse_str(file_get_contents('php://input'), $putParams);
            $request = array_merge($request, $putParams);
        }
        foreach ($request as $key => $input) {
            if (gettype($input) === 'string') {
                $input = str_replace('/\s+/', ' ', $input);
                $input = htmlspecialchars_decode($input);
            } elseif (gettype($input) != 'array') {
                $input = strip_tags($input);
            }

            if (!in_array($key, ["count", "current"]) && !is_numeric($key)) {
                $inputs[$key] = $input;
            }
        }

        return (object)$inputs;
    }

    private function parsePath()
    {
        $pathParts = explode('?', $this->path);
        $this->path = $pathParts[0];

        $pathSegments = explode('/', trim($this->path, '/'));

        $this->routeParams = array_slice($pathSegments, 0);
    }

    private function parseQueryParams()
    {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '';

        parse_str($query, $queryParams);

        if (isset($queryParams['options'])) :
            $options = json_decode(
                base64_decode(
                    $queryParams['options']
                )
            );
            if (isset($options->count)) :
                $queryParams['count'] = $options->count;
                unset($options->count);
            endif;

            if (isset($options->current)) :
                $queryParams['current'] = $options->current;
                unset($options->current);
            endif;

            $queryParams['options'] =  $options;
        endif;

        $this->queryParams = $queryParams;
    }

    private function getTranslate($path)
    {
        $pathSegments = explode('/', trim($path, '/'));

        if (in_array($pathSegments[0], LanguageLoader::$existLanguages)) :
            $_SESSION['language'] = $pathSegments[0];
            array_shift($pathSegments);
        else :
            if (!isset($_SESSION['language'])) :
                $_SESSION['language'] = 'en';
            endif;
        endif;

        return '/' . implode('/', $pathSegments);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }
}
