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

use PHPUnit\Framework\TestCase;
use A11yBuddy\Router;

class RouterTest extends TestCase
{

    public function testRegularNoPlaceholderRoute()
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

    public function testSinglePlaceholderRoute()
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

    public function testMultiplePlaceholderRoute()
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

    public function testSingleUnexpectedToken()
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

    public function testMultipleUnexpectedTokens()
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