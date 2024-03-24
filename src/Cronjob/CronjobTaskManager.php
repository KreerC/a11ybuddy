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

    public function __construct()
    {
        $this->registerAllTasks();
    }

    /**
     * Registers all tasks that are shipped and required by the application.
     */
    private function registerAllTasks(): void
    {
        // TODO
        return;
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
     */
    public function runTasks()
    {
        foreach ($this->tasks as $task) {
            if ($task->canRun())
                $task->run();
        }
    }

}