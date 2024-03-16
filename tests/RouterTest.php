<?php

use PHPUnit\Framework\TestCase;
use A11yBuddy\Router;

class RouterTest extends TestCase
{

    public function testAddRoute(): void
    {
        $router = new Router();

        $route = '/home';
        $handler = function () {
            return "Home route";
        };
        $result = $router->addRoute("GET", $route, $handler);
        $this->assertTrue($result);

        // Test not overriding the route
        $result = $router->addRoute("GET", $route, $handler);
        $this->assertFalse($result);

        // Test overriding the route
        $result = $router->addRoute("GET", $route, $handler, true);
        $this->assertTrue($result);
    }

    public function testRegularNoPlaceholderRoute(): void
    {
        $router = new Router();

        $route = '/home';
        $expectedPattern = '/^\/home$/';
        $actualPattern = $router->buildPattern($route);
        $this->assertEquals($expectedPattern, $actualPattern);

        $router->addRoute("GET", $route, function () {
            return "Home route";
        });
        $result = $router->handleRequest("GET", $route);
        $this->assertEquals("Home route", $result);

        // Test whether there is an exception when the route is called as POST
        $this->expectException(\Exception::class);
        $router->handleRequest("POST", $route);
    }

    public function testSinglePlaceholderRoute(): void
    {
        $router = new Router();

        $route = '/user/{id}';
        $expectedPattern = '/^\/user\/(?P<id>[a-zA-Z0-9_]+)$/';
        $actualPattern = $router->buildPattern($route);
        $this->assertEquals($expectedPattern, $actualPattern);

        $router->addRoute("POST", $route, function ($params) {
            return "User " . $params["id"];
        });
        $result = $router->handleRequest("POST", '/user/123');
        $this->assertEquals("User 123", $result);
    }

    public function testMultiplePlaceholderRoute(): void
    {
        $router = new Router();

        $route = '/user/{id}/tests/{testId}';
        $expectedPattern = '/^\/user\/(?P<id>[a-zA-Z0-9_]+)\/tests\/(?P<testId>[a-zA-Z0-9_]+)$/';
        $actualPattern = $router->buildPattern($route);
        $this->assertEquals($expectedPattern, $actualPattern);

        $router->addRoute("GET", $route, function ($params) {
            return "User " . $params["id"] . ", Test " . $params["testId"];
        });
        $result = $router->handleRequest("GET", '/user/123/tests/456');
        $this->assertEquals("User 123, Test 456", $result);
    }

    public function testSingleUnexpectedToken(): void
    {
        $router = new Router();

        $route = '/user/{id}';

        $router->addRoute("GET", $route, function ($params) {
            return "User " . $params["id"];
        });

        // Test unexpected token in route
        $this->expectException(\Exception::class);
        $result = $router->handleRequest("GET", '/user/123$');
    }

    public function testMultipleUnexpectedTokens(): void
    {
        $router = new Router();

        $route = '/user/{id}';

        $router->addRoute("GET", $route, function ($params) {
            return "User " . $params["id"];
        });

        // Test unexpected token in route with more special characters
        $this->expectException(\Exception::class);
        $result = $router->handleRequest("GET", '/user/!@#$%^&*()');
    }

}