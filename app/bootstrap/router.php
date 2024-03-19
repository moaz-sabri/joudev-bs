<?php

namespace App\Bootstrap;

class Router
{
    private $routes = [];

    private function hendlerMethod($method, $path, $className, $action)
    {
        if (is_array($path)) :
            foreach ($path as $key => $p) {
                $this->addRoute($method, $p, $className, $action);
            }
        else :
            $this->addRoute($method, $path, $className, $action);
        endif;
    }

    private function addRoute($method, $path, $className, $action)
    {
        // Extract route parameters from path
        $pattern = $this->buildRoutePattern($path);
        $routeParams = $this->extractRouteParams($path);

        $this->routes[$method][$pattern] = [
            'handler' => function ($request) use ($className, $action) {
                return $this->buildViewer($request, $className, $action);
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

    private function buildViewer($request, $className, $action)
    {
        $output = new Output();
        $response = $className->$action($request);
        if (isset($response->view)) :
            return $output->view($response);
        else :
            return $response;
        endif;
    }

    public function get($path, $className, $action)
    {
        $this->hendlerMethod('GET', $path, $className, $action);
    }

    public function post($path, $className, $action)
    {
        $this->hendlerMethod('POST', $path, $className, $action);
    }

    public function put($path, $className, $action)
    {
        $this->hendlerMethod('PUT', $path, $className, $action);
    }

    public function delete($path, $className, $action)
    {
        $this->hendlerMethod('DELETE', $path, $className, $action);
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
                    } elseif (is_array($response)) {
                        return new Response(...$response);
                    } else {
                        // Handle invalid response
                        return new Response('Internal Server Error Router', 500);
                    }
                }
            }
        }

        // Handle 404 Not Found
        return new Response('/404?url=' . $path, 301);
    }
}
