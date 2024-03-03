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
 * Renders the current page using the supplied template.
 */
class TemplateRenderer
{
    private string $template;

    /**
     * Create a new TemplateRenderer instance.
     * 
     * @param string $templateFile The path to the template file to use.
     */
    public function __construct(string $templateFile = "template/index.html")
    {
        $this->template = file_get_contents($templateFile);
    }

    /**
     * Fills the template with the variables.
     * 
     * @return string The filled template.
     */
    public function fillVariables(): string
    {
        $code = $this->template;

        $code = str_replace("{{ PORTAL_NAME }}", Application::NAME, $code);
        $code = str_replace("{{ PORTAL_VERSION }}", Application::VERSION, $code);
        return $code;
    }

    /**
     * Renders the template to the output buffer.
     * 
     * @return void
     */
    public function render(): void
    {
        echo $this->fillVariables();
    }

}