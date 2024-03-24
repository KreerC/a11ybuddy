<?php

namespace A11yBuddy\Cronjob;

/**
 * A task that can be run periodically.
 * Tasks will be run via CLI through cron job.
 */
abstract class CronjobTask
{

    /**
     * Checks if the task can be run.
     * Because cron jobs run every minute, this method can be used to check if the task should be run at this time or not.
     * 
     * @param int $timestamp The timestamp to check for. If it is -1, use the current time instead.
     * @return bool True if the task can be run, false otherwise.
     */
    public function canRun(int $timestamp = -1): bool
    {
        return true;
    }

    /**
     * Runs the task.
     */
    public abstract function run(): void;

}