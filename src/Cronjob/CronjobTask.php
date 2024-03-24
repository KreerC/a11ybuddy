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
     */
    public function canRun(): bool
    {
        return true;
    }

    /**
     * Runs the task.
     */
    public abstract function run(): void;

}