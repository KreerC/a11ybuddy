<?php

namespace A11yBuddy\Cronjob\Tasks\Logging;

use A11yBuddy\Application;
use A11yBuddy\Cronjob\CronjobTask;
use A11yBuddy\Logger;

class PurgeLogsTask extends CronjobTask
{

    public function canRun(): bool
    {
        // Run this only once per day
        return $this->plannedTimestamp % 86400 === 0;
    }

    public function run(): void
    {
        // Get all log files in the logs directory
        $logFiles = glob("logs/*.log");

        // Move the current log file to a new file
        foreach ($logFiles as $logFile) {
            $newLogFile = $logFile . "." . date("Ymd");
            rename($logFile, $newLogFile);
        }

        // Delete all files from the logs directory that are older than X days
        $keepForDays = Application::getInstance()->getConfig()["logging"]["keepForDays"] ?? 7;
        foreach (scandir("logs") as $file) {
            if (is_file("logs/" . $file) && time() - filemtime("logs/" . $file) > $keepForDays * 24 * 60 * 60) {
                unlink("logs/" . $file);
            }
        }
    }

}