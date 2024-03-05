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

/**
 * The starting point of the application.
 * Defines some basic configuration.
 * 
 * This class is a singleton. Use Application::getInstance() to get the current instance.
 */
class Application
{

    const VERSION = "0.0.1";
    const NAME = "a11yBuddy";

    private static ?Application $instance = null;
    private TemplateRenderer $templateRenderer;

    public function __construct()
    {
        self::$instance = $this;

        $this->templateRenderer = new TemplateRenderer();
        $this->templateRenderer->render();
    }

    /**
     * Singleton method to get the current instance of the Application.
     * 
     * @return Application The current instance of the Application.
     */
    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

}