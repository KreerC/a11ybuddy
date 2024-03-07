<?php

/*
   Copyright 2024 Casey Kreer

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace A11yBuddy;

class Router
{
    private $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];

    private static string $requestUri = "/";
    private static string $requestMethod = "GET";

    public function __construct()
    {
        $uri = $_SERVER["REQUEST_URI"] ?? "/";
        self::$requestUri = explode("?", $uri)[0];
        self::$requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";
    }

    /**
     * Register a new route.
     * 
     * @param string $method The HTTP method of the route.
     * @param string $path The path of the route. You can use placeholders like {id}.
     * @param callable|array $handler The handler for the route. Can be a function or a class method.
     * @param bool $override Whether to override an existing route. False by default.
     * 
     * @return bool Whether the route was added successfully.
     */
    public function addRoute(string $method, string $path, callable|array $handler, bool $override = false): bool
    {
        if (!isset($this->routes[$method])) {
            return false;
        }

        if (isset($this->routes[$method][$path]) && !$override) {
            return false;
        }

        $this->routes[$method][$path] = $handler;
        return true;
    }

    /**
     * Handle a request.
     * 
     * @param string $method The HTTP method of the request.
     * @param string $requestPath The path of the request.
     * @return mixed The result of the handler.
     */
    public function handleRequest(string $method, string $requestPath)
    {
        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = $this->buildPattern($route);

            if (preg_match($pattern, $requestPath, $matches)) {
                // Remove the full match
                array_shift($matches);

                // If the handler is an array, it's a class method
                if (is_array($handler)) {
                    $class = $handler[0];
                    $method = $handler[1];
                    return call_user_func_array([new $class, $method], $matches);
                }

                // If the handler is a callable, it's a function
                if (is_callable($handler)) {
                    return call_user_func($handler, $matches);
                }
            }
        }

        // Route to 404 if it exists
        if (isset($this->routes["GET"]["/404"])) {
            return call_user_func_array($this->routes["GET"]["/404"], []);
        }

        throw new \Exception("Route not found");
    }

    /**
     * Utility function to parse variables in a route.
     * 
     * @param string $route The route to parse.
     * @return string The parsed route.
     */
    public function buildPattern(string $route): string
    {
        $pattern = preg_replace('/\//', '\\/', $route);
        $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '(?P<$1>[a-zA-Z0-9_]+)', $pattern);
        $pattern = '/^' . $pattern . '$/';
        return $pattern;
    }

    /**
     * @return string The current request URI.
     */
    public static function getRequestUri(): string
    {
        return self::$requestUri;
    }

    /**
     * @return string The current request method.
     */
    public static function getRequestMethod(): string
    {
        return self::$requestMethod;
    }

}