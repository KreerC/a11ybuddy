<?php

use A11yBuddy\Cronjob\CronjobTask;
use PHPUnit\Framework\TestCase;
use A11yBuddy\Cronjob\CronjobTaskManager;

class TestCronjobTask extends CronjobTask
{

    public bool $run = false;

    public function run(): void
    {
        $this->run = true;
    }

}

class TimedTestCronjobTask extends TestCronjobTask
{

    public function canRun(): bool
    {
        // If more than 60 seconds have passed before running, don't run.
        if ($this->plannedTimestamp <= time() - 60)
            return false;

        return true;
    }

}

class CronjobTaskManagerTest extends TestCase
{

    public function testAddAndExecuteCronjobTask(): void
    {
        $taskManager = new CronjobTaskManager();

        $task = new TestCronjobTask();

        $taskManager->addTask($task);
        $taskManager->runTasks();

        $this->assertTrue($task->run);
    }

    public function testTimedCronjobTask(): void
    {
        $taskManager = new CronjobTaskManager();

        $task = new TimedTestCronjobTask();

        // Simulate 61 seconds passing
        $taskManager->runTasks(time() + 61);
        $this->assertFalse($task->run);
    }

}