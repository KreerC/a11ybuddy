<?php

namespace A11yBuddy\Cronjob;

use A11yBuddy\Logger;

/**
 * Manages periodic tasks that run via cron job.
 */
class CronjobTaskManager
{

    /**
     * @var CronjobTask[] The tasks that are registered with the manager.
     */
    private array $tasks = [];

    /**
     * Registers all tasks that are shipped and required by the application.
     */
    public function registerInbuiltTasks(): void
    {
        $this->addTask(new Tasks\Account\DeleteUnverifiedUsersTask());
        $this->addTask(new Tasks\Logging\PurgeLogsTask());
    }

    /** 
     * Adds a task to the manager.
     */
    public function addTask(CronjobTask $task): void
    {
        $this->tasks[] = $task;
    }

    /**
     * Runs all tasks that can be run.
     * 
     * @param null|int $timestamp The timestamp to check a tasks ability to run for. 
     *  If it is null, use the current time instead.
     * @param bool $roundToNearestMinute If true, round the timestamp to the nearest minute.
     */
    public function runTasks(null|int $timestamp = null, bool $roundToNearestMinute = true): void
    {
        // Because some tasks might take a really long time to run 
        // and block the next task from running at the right time,
        // we will get the current time once and pass it down to all tasks.
        if ($timestamp === null)
            $timestamp = time();

        if ($roundToNearestMinute)
            $timestamp = $timestamp - $timestamp % 60;

        foreach ($this->tasks as $task) {
            $task->plannedTimestamp = $timestamp;

            if ($task->canRun()) {
                Logger::info("Running Task " . $task::class);
                $task->run();
            }
        }
    }

}