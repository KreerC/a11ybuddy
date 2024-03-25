<?php

namespace A11yBuddy;

class Logger
{

    /**
     * Toggler for debug mode. Specifies whether you want to log debug messages or not.
     */
    public static bool $isDebugMode = false;

    public static function error(string $message): void
    {
        self::log($message, 'ERROR');
    }

    public static function info(string $message): void
    {
        self::log($message, 'INFO');
    }

    public static function debug(string $message): void
    {
        if (self::$isDebugMode) {
            self::log($message, 'DEBUG');
        }
    }

    private static function log(string $message, string $level): void
    {
        error_log("[" . date("H:i:s") . "] " . $message . PHP_EOL, 3, 'logs/' . $level . '.log');
    }

}