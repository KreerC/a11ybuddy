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

class Localize
{

    private static ?Localize $instance = null;

    private string $locale;

    private array $translations = [];

    public function __construct(string $defaultLocale = 'en')
    {
        self::$instance = $this;

        // Parse the locale from the user's browser
        $this->locale = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $this->locale = basename(explode('-', $this->locale)[0]);

        // Check if the locale is supported
        if (!file_exists(__DIR__ . "/../../../locale/{$this->locale}.ini")) {
            $this->locale = $defaultLocale;
        }

        // Load the corresponding language file
        $result = parse_ini_file(__DIR__ . "/../../../locale/{$this->locale}.ini");

        if ($result === false) {
            throw new \Exception("Failed to load language file for locale '{$this->locale}'");
        }

        $this->translations = $result;
    }

    /**
     * Translate a key into the user's language
     * @param string $key
     * @param string $default The default value if the key is not found
     * @param array $variables Variables to replace in the string
     * @return string
     */
    public static function translate(string $key, string $default = 'Missing translation', array $variables = []): string
    {
        $instance = self::getInstance();
        $translation = $instance->getTranslation($key);

        if ($translation === '') {
            $translation = $default;

            // Make it easy for developers to spot missing translations
            if (Application::DEVELOPER_MODE) {
                $translation = '<span title="No translation provided" style="color: red; border: 5px red solid;">' . $translation . "</span>";
            }
        }

        // If there are variables, replace them in the string
        if (!empty($variables)) {
            $translation = strtr($translation, $variables);
        }

        return $translation;
    }

    public static function getInstance(): Localize
    {
        if (self::$instance === null) {
            self::$instance = new Localize();
        }
        return self::$instance;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getTranslation(string $key): string
    {
        return $this->translations[$key] ?? '';
    }

}