<?php

namespace A11yBuddy;

use A11yBuddy\Frontend\BasePage\NotFoundController;

/**
 * Responsible for routing frontend user requests to the correct A11yBuddy\Frontend\Controller.
 */
class Router
{

    private static string $requestUri = "/";
    private static string $requestMethod = "GET";

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


    private $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];

    /**
     * Upon instantiation, the Router will set the request URI and method.
     * These are useful constants for the rest of the application.
     */
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
     * @param string|callable $handler The handler for the route. Can be a class or a function.
     * @param bool $override Whether to override an existing route. False by default.
     * 
     * @return bool Whether the route was added successfully.
     */
    public function addRoute(string $method, string $path, string|callable $handler, bool $override = false): bool
    {
        if (!isset ($this->routes[$method])) {
            return false;
        }

        if (isset ($this->routes[$method][$path]) && !$override) {
            return false;
        }

        $this->routes[$method][$path] = $handler;
        return true;
    }

    /**
     * Returns the corresponding controller for a given request.
     * 
     * @param string $method The HTTP method of the request.
     * @param string $requestPath The path of the request.
     * @return array An array containing the controller and the matches from the route.
     */
    public function getControllerForRequest(string $method, string $requestPath): array
    {
        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = $this->buildPattern($route);

            if (preg_match($pattern, $requestPath, $matches)) {
                // Remove the full match
                array_shift($matches);

                // If the handler is a callable, it's a function
                if (is_callable($handler)) {
                    return [$handler, $matches];
                }

                // If the handler is a class, it's a controller
                if (class_exists($handler)) {
                    return [new $handler(), $matches];
                }

                Logger::error("Handler for " . $requestPath . " is not a function or a class");
                throw new \Exception("Handler for " . $requestPath . " is not a function or a class");
            }
        }

        // Route to 404 if no route is found
        return [new NotFoundController(), []];
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

}