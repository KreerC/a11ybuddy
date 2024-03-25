<?php

namespace A11yBuddy;

/**
 * A really simple logger that logs messages to files.
 */
class Logger
{

    /**
     * Toggler for debug mode. Specifies whether you want to log debug messages or not.
     */
    public static bool $isDebugMode = false;

    /**
     * @param string $message The error message to log.
     */
    public static function error(string $message): void
    {
        self::log($message, 'ERROR');
    }

    /**
     * @param string $message The warning message to log.
     */
    public static function warning(string $message): void
    {
        self::log($message, 'WARNING');
    }

    /**
     * @param string $message The info message to log.
     */
    public static function info(string $message): void
    {
        self::log($message, 'INFO');
    }

    /**
     * Logs a debug message if debug mode is enabled. See static $isDebugMode.
     * 
     * @param string $message The debug message to log.
     */
    public static function debug(string $message): void
    {
        if (self::$isDebugMode) {
            self::log($message, 'DEBUG');
        }
    }

    /**
     * Logs a message to a file. The log file is located in the logs directory.
     * 
     * @param string $message The message to log.
     * @param string $level The log level (ERROR, INFO, DEBUG, ...).
     */
    private static function log(string $message, string $level): void
    {
        error_log("[" . date("H:i:s") . "] " . $message . PHP_EOL, 3, 'logs/' . $level . '.log');

        // If debug mode is enabled, also log to the PHP webserver console
        if (self::$isDebugMode) {
            error_log("[" . $level . "] " . $message . PHP_EOL, 4);
        }
    }

}