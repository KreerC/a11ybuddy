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

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\BasePageRenderer;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Router;

/**
 * Class PageStructure
 * 
 * Renders the basic structure of a page and handles routing for the main content
 */
class BasePageController implements Controller
{

    private BasePageRenderer $renderer;

    public function __construct(BasePageRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return BasePageRenderer
     */
    public function getRenderer(): BasePageRenderer
    {
        return $this->renderer;
    }

    public function run(array $data = [])
    {
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php HeadView::render($data); ?>
        </head>

        <body>
            <?php NavigationView::render($data); ?>

            <main>
                <div class="container mt-3">
                    <?php
                    $router = $this->getRenderer()->getRouter();
                    $router->handleRequest(Router::getRequestMethod(), Router::getRequestUri());
                    ?>
                </div>
            </main>

            <?php FooterView::render($data); ?>
        </body>

        </html>

        <?php
    }

}