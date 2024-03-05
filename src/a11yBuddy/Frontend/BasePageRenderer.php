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

use A11yBuddy\Frontend\BasePage\Homepage;
use A11yBuddy\Frontend\BasePage\PageStructure;
use A11yBuddy\Router;

class BasePageRenderer
{

    private Router $router;
    private PageStructure $pageStructure;

    public function __construct()
    {
        $this->router = new Router();

        $this->registerRoutes();

        $this->pageStructure = new PageStructure($this);

        $this->pageStructure->render();
    }

    private function registerRoutes()
    {
        $this->router->addRoute("GET", "/", [Homepage::class, "render"]);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

}