<?php

namespace A11yBuddy\Cronjob;

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
     * @param int $timestamp The timestamp to check a tasks ability to run for. 
     *  If it is -1, use the current time instead.
     */
    public function runTasks(int $timestamp = -1): void
    {
        // Because some tasks might take a really long time to run 
        // and block the next task from running at the right time,
        // we will get the current time once and pass it down to all tasks.
        if ($timestamp === -1)
            $timestamp = time();

        echo "Running tasks at " . date('Y-m-d H:i:s', $timestamp) . "\n";

        foreach ($this->tasks as $task) {
            $task->plannedTimestamp = $timestamp;

            if ($task->canRun()) {
                echo "Executing " . $task::class . "\n";
                $task->run();
            } else {
                echo "Skipping " . $task::class . "\n";
            }
        }
    }

}