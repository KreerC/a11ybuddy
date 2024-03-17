<?php

use A11yBuddy\Frontend\BasePage\NotFoundController;
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

        $function = function () {
            return;
        };

        $router->addRoute("GET", $route, $function);
        $result = $router->getControllerForRequest("GET", $route)[0];
        $this->assertEquals($function, $result);

        // Test whether there is a 404 error when the route does not exist
        $result = $router->getControllerForRequest("POST", $route)[0];
        $this->assertInstanceOf(NotFoundController::class, $result);
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
        $result = $router->getControllerForRequest("POST", '/user/123');
        $result = $result[0]($result[1]);
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
        $result = $router->getControllerForRequest("GET", '/user/123/tests/456');
        $result = $result[0]($result[1]);
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
        $result = $router->getControllerForRequest("GET", '/user/123$');
        $this->assertInstanceOf(NotFoundController::class, $result[0]);
    }

    public function testMultipleUnexpectedTokens(): void
    {
        $router = new Router();

        $route = '/user/{id}';

        $router->addRoute("GET", $route, function ($params) {
            return "User " . $params["id"];
        });

        $result = $router->getControllerForRequest("GET", '/user/!@#$%^&*()');
        $this->assertInstanceOf(NotFoundController::class, $result[0]);
    }

}