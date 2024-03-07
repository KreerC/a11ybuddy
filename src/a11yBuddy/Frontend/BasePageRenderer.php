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

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\BasePageController;
use A11yBuddy\Frontend\CreateProject\CreateProjectController;
use A11yBuddy\Frontend\CreateProject\CreateProjectView;
use A11yBuddy\Frontend\BasePage\HomepageView;
use A11yBuddy\Frontend\BasePage\NotFoundView;
use A11yBuddy\Router;

class BasePageRenderer
{

    private Router $router;
    private BasePageController $pageController;

    public function __construct()
    {
        $this->router = new Router();
        $this->registerRoutes();

        $this->pageController = new BasePageController($this);
    }

    public function render(): void
    {
        $this->pageController->run();
    }

    /**
     * Central location for registering routes for the application
     */
    private function registerRoutes()
    {
        // Add special routes
        $this->router->addRoute("GET", "/404", [NotFoundView::class, "render"]);

        // All other routes
        $this->router->addRoute("GET", "/", [HomepageView::class, "render"]);

        $this->router->addRoute("GET", "/create", [CreateProjectView::class, "render"]);
        $this->router->addRoute("POST", "/create", [CreateProjectController::class, "run"]);

        // Register custom pages
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];
        foreach ($customPages as $route => $page) {
            $this->router->addRoute("GET", $route, [CustomPageController::class, "run"]);
        }
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

}