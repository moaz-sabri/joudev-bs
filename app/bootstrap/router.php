<?php

namespace App\Bootstrap;

class Router
{
    private $routes = [];


    public function get($path, $className, $action)
    {
        $this->addRoute('GET', $path, $className, $action);
    }

    public function post($path, $className, $action)
    {
        $this->addRoute('POST', $path, $className, $action);
    }

    public function put($path, $className, $action)
    {
        $this->addRoute('PUT', $path, $className, $action);
    }

    public function delete($path, $className, $action)
    {
        $this->addRoute('DELETE', $path, $className, $action);
    }

    public function patch($path, $className, $action)
    {
        $this->addRoute('PATCH', $path, $className, $action);
    }

    private function addRoute($method, $path, $className, $action)
    {
        // Extract route parameters from path
        $pattern = $this->buildRoutePattern($path);
        $routeParams = $this->extractRouteParams($path);

        $this->routes[$method][$pattern] = [
            'handler' => function ($request) use ($className, $action) {
                $output = new Output();
                return $output->build($className->$action($request));
            },
            'params' => $routeParams
        ];
    }

    // Build regex pattern for the given route path
    private function buildRoutePattern($path)
    {
        $escapedPath = preg_quote($path, '|');
        // Add start and end delimiters to the pattern
        return '|^' . preg_replace_callback('/\\\{([^\/]+)\\\}/', function ($matches) {
            return "(?P<{$matches[1]}>[^\/]+)";
        }, $escapedPath) . '$|';
    }

    private function extractRouteParams($path)
    {
        preg_match_all('|{([^\/]+)}|', $path, $matches);
        return $matches[1];
    }

    public function dispatch($request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $pattern => $route) {
                if (preg_match($pattern, $path, $matches)) {

                    $params = [];
                    foreach ($route['params'] as $param) {
                        $params[$param] = $matches[$param];
                    }

                    $request->routeParams = (object)$params;
                    $request->queryParams = (object) $request->getQueryParams();

                    $handler = $route['handler'];
                    $response = call_user_func_array($handler, [$request]);

                    if (LOADINGPROCESS) debug("before load the page!");

                    if ($response instanceof Response) {
                        return $response;
                    } else {

                        return new FailResponse(500);
                    }
                }
            }
        }

        return new FailResponse(404);
    }
}
