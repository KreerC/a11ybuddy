<?php

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;

/**
 * Localization utilities for the frontend
 */
class Localize
{

    private static ?Localize $instance = null;

    private string $locale;

    private array $translations = [];

    public function __construct(string $defaultLocale = 'en', string|bool $localeIni = false)
    {
        self::$instance = $this;

        // For testing purposes, we can pass a custom string
        if ($localeIni) {
            $result = parse_ini_string($localeIni);
            if ($result === false) {
                throw new \Exception("Failed to load locale definitions from string");
            }
            $this->locale = $defaultLocale;
            $this->translations = $result;
            return;
        }

        // Parse the locale from the user's browser
        $this->locale = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']) ?? $defaultLocale;
        $this->locale = basename(explode('-', $this->locale)[0]);

        // Check if the locale is supported
        if (!file_exists(__DIR__ . "/../../locale/{$this->locale}.ini")) {
            $this->locale = $defaultLocale;
        }

        // Load the corresponding language file
        $result = parse_ini_file(__DIR__ . "/../../locale/{$this->locale}.ini");

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