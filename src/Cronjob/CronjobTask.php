<?php

namespace A11yBuddy\Cronjob;

/**
 * A task that can be run periodically.
 * Tasks will be run via CLI through cron job.
 */
abstract class CronjobTask
{

    /**
     * The timestamp when the task is planned to run.
     * This is set by the CronjobTaskManager.
     */
    public int $plannedTimestamp = -1;

    /**
     * Checks if the task can be run.
     * Because cron jobs run every minute, this method can be used to check if the task should be run at this time or not.
     * 
     * @return bool True if the task can be run, false otherwise.
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